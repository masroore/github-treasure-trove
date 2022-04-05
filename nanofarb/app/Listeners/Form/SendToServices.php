<?php

namespace App\Listeners\Form;

use App\Helpers\Sales\PromoCodeGenerator;
use App\Models\Shop\Sale;
use Exception;
use Log;

class SendToServices
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     */
    public function handle($event): void
    {
        $form = $event->form;

        $this->sendToSendPulse($form);

//        $this->sendToBitrix24($form);
    }

    protected function sendToSendPulse($form): void
    {
        if (in_array($form->type, ['subscribers']) && !empty($form->data['email'])) {
            if (variable('sendpulse_address_book_id')) {

                // Generate promocode
                $code = '';
                if (variable('sale_id_for_subscribers') && ($sale = Sale::find(variable('sale_id_for_subscribers')))) {
                    $codeGenerator = new PromoCodeGenerator();
                    $code = $codeGenerator->generateOne();
                    $sale->promoCodes()->create([
                        'code' => $code,
                        'transferred' => true,
                    ]);
                }

                $additionalParams = [];
                if (variable('sendpulse_confirmation_sender_email')) {
                    $additionalParams = [
                        'confirmation' => 'force',
                        'sender_email' => variable('sendpulse_confirmation_sender_email'),
                    ];
                }

                app('SendPulse')->addEmails(variable('sendpulse_address_book_id'), [
                    [
                        'email' => $form->data['email'],
                        'variables' => [
                            'phone' => $form->data['phone'] ?? '',
                            'name' => $form->data['name'] ?? '',
                            'promocode' => $code,
                        ],
                    ],

                ], $additionalParams);
            }
        }
    }

    protected function sendToBitrix24($form): void
    {
        if (variable('bitrix24_host') && variable('bitrix24_user') && variable('bitrix24_hook_code')) {
            $subject = config("web-forms.$form->type.email.subject", $form->type);

            try {
                // форма "Сотрудничество"
                if ($form->type == 'contacts') {
                    $b24 = new \Fomvasss\Bitrix24ApiHook\Bitrix24(variable('bitrix24_host'), variable('bitrix24_user'), variable('bitrix24_hook_code'));

                    $b24->crmLeadAdd([
                        'fields' => [
                            'TITLE' => $subject,
                            'NAME' => $form->data['name'] ?? '',
                            'EMAIL' => [
                                ['VALUE' => $form->data['email'] ?? ''],
                            ],
                            'PHONE' => [
                                ['VALUE' => $form->data['phone'] ?? ''],
                            ],
                            'COMMENTS' => $form->data['message'] ?? '',
                            'ADDRESS_CITY' => $form->data['city'],
                            // Город, Адрес??? ADDRESS
                            //'UF_CRM_1556001206' => ['VALUE' => optional($form->terms->where('vocabulary', 'types_trade_services')->first())->name], //Вид торг. услуг
                            'UF_CRM_1556001206' => optional($form->terms->where('vocabulary', 'types_trade_services')->first())->name,
                            //Вид торг. услуг
                            'UF_CRM_1556001258' => empty($form->data['subscribe']) ? false : true,
                            //Подписался на новости
                        ],
                        'params' => ['REGISTER_SONET_EVENT' => 'Y'],
                    ]);
                // форма "Купить в один клик"
                } elseif ($form->type == 'buy_one_click') {
//                    $b24 = new \Fomvasss\Bitrix24ApiHook\Bitrix24(variable('bitrix24_host'), variable('bitrix24_user'), variable('bitrix24_hook_code'));
                }
            } catch (Exception $exception) {
                Log::error($exception->getMessage());
                Log::error("Form ID: $form->id");
            }
        }
    }
}
