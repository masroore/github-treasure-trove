<?php

namespace App\Listeners\Shop;

use Exception;
use Log;
use Mail;

class SendEmailOrderConfirmed
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     */
    public function handle($event): void
    {
        $order = $event->order;

        $mails = array_map(function ($mail) {
            return trim($mail);
        }, explode(',', variable('mail_to_address')));
        if ($mails) {
            Mail::to($mails)
                ->send(new \App\Mail\CustomMail('Новый заказ ' . config('app.name'), 'emails.admin.after-order-confirm', [
                    'order' => $order,
                ]));
        }

        if (($user = $order->user) && $user->email) {
            Mail::to($order->user)
                ->send(new \App\Mail\CustomMail('Ваш заказ принят', 'emails.front.after-order-confirm', [
                    'user' => $user, 'order' => $order,
                ]));
        }

        $this->sendToBitrix24($order);
    }

    protected function sendToBitrix24($order): void
    {
        if (variable('bitrix24_host') && variable('bitrix24_user') && variable('bitrix24_hook_code')) {
            try {
                $b24 = new \Fomvasss\Bitrix24ApiHook\Bitrix24(variable('bitrix24_host'), variable('bitrix24_user'), variable('bitrix24_hook_code'));

                // Тип (метод) оплаты
                if (($order->data['payment']['method'] ?? '') == 'upon_receipt') {
                    $paymentMethod = 'Наличные';
                } elseif (($order->data['payment']['method'] ?? '') == 'prepaid_card') {
                    $paymentMethod = 'Предоплата на карту';
                } else {
                    $paymentMethod = $order->data['payment']['method'] ?? '-';
                }

                // Метод доставки
                $deliveryMethod = '-';
                if (($order->data['delivery']['method'] ?? '') == 'novaposhta') {
                    $deliveryMethod = 'Новая почта';
                    if (($order->data['delivery']['tariff'] ?? '') == 'pvz') {
                        $deliveryMethod .= ': В отделение';
                    } elseif (($order->data['delivery']['tariff'] ?? '') == 'pvz') {
                        $deliveryMethod .= ': Курьер';
                    }
//                } elseif (($order->data['delivery']['method'] ?? '') == 'courier') {
//                    $deliveryMethod = 'Курьер';
                } elseif (($order->data['delivery']['method'] ?? '') == 'pickup') {
                    $deliveryMethod = 'Самовывоз';
                }

                // преминенные акции/скидки
                $salesStr = '';
                foreach ($order->data['sales'] ?? []  as $sale) {
                    $salesStr .= ($sale['name'] ?? '') . '(' . ($sale['id'] ?? '') . '); ';
                }

                $orderData = [
                    'category_id' => null,                                                  // направление
                    'number' => $order->number,                                             // Номер заказа
                    'title' => 'Заказ #' . $order->number,
                    'ordered_at' => optional($order->ordered_at)->toDateTimeString(),       // Дата оформления
                    'payment_status' => optional($order->txPaymentStatus)->name ?? '-',     // Статус оплаты
                    'sum' => round($order->getFinalSumStr(false) / 100),                    // Сумма заказа
                    'discount' => round(($order->data['purchase']['discount'] ?? 0) / 100), // Скидка
                    'delivery_price' => round(($order->data['purchase']['delivery'] ?? 0) / 100), // Стоимость доставки
                    'promocode' => $order->data['sales']['promocode'] ?? '',                // Промокод
                    'payment_method' => $paymentMethod,                                     // Метод оплаты
                    'delivery_method' => $deliveryMethod,                                   // Метод доставки
                    'address' => $order->data['delivery']['address'] ?? '',                 // TODO: Адрес доставки заказа
                    'city' => $order->data['delivery']['city'] ?? '',                       // Город
                    'pvz' => $order->data['delivery']['pvz'] ?? '',                         // Отделение
                    'sales' => $salesStr,
                ];

                $fieldsMatching = json_decode(variable('bitrix_fields', '[]'), true);

                $fields = [];
                foreach ($fieldsMatching as $appKey => $bitrixKey) {
                    if (isset($orderData[$appKey]) && $orderData[$appKey] !== null) {
                        $fields[$bitrixKey] = $orderData[$appKey];
                    }
                }

                // Создаем сделку
                $b24Deal = $b24->crmDealAdd([
                    'fields' => $fields,
                    'params' => ['REGISTER_SONET_EVENT' => 'Y'],
                ]);

                // Получаем товар с Bitrix24 (по Sku - XML_ID)
                $b24Products = $b24->crmProductList([
                    'filter' => [
                        'XML_ID' => $order->products->pluck('sku')->toArray(),
                    ],
                    'select' => ['ID', 'XML_ID'],
                ]);

                $prods = [];
                foreach ($b24Products['result'] ?? [] as $prod) {
                    $prods[$prod['XML_ID']] = $prod['ID'];
                }

                $rows = [];
                foreach ($order->products as $product) {
                    if (isset($prods[$product->sku])) {
                        $rows[] = [
                            'PRODUCT_ID' => $prods[$product->sku],
                            'PRICE' => $product->pivot->price / 100,
                            'QUANTITY' => $product->pivot->quantity,
                        ];
                    } else {
                        Log::error(__METHOD__ . "Product SKU:$product->sku not found in base Bitrix24 (Order id: $order->id)");
                    }
                }

                // Добавляем к сделки товары
                $b24->crmDealProductrowsSet([
                    'id' => $b24Deal['result'],
                    'rows' => $rows,
                ]);

                // Создаем контакт
                $b24Contact = $b24->crmContactAdd([
                    'fields' => [
                        'NAME' => $order->data['delivery']['name'] ?? '',
                        'PHONE' => [
                            ['VALUE' => $order->data['delivery']['phone'] ?? ''],
                        ],
                        'EMAIL' => [
                            ['VALUE' => $order->data['delivery']['email'] ?? ''],
                        ],
                        'ADDRESS_CITY' => $order->data['delivery']['city'] ?? '',
                    ],
                ]);

                // Добавляем к сделке контакт
                if (isset($b24Contact['result']) && ($b24ContactId = $b24Contact['result'])) {
                    $b24->crmDealContactItemsSet([
                        'id' => $b24Deal['result'],
                        'items' => [
                            ['CONTACT_ID' => $b24Contact['result']],
                        ],
                    ]);
                }
            } catch (Exception $exception) {
                Log::error($exception->getMessage());
                Log::error("Order ID $order->id");
            }
        }
    }
}
