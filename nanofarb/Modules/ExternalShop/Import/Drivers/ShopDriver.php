<?php

namespace Modules\ExternalShop\Import\Drivers;

use Modules\ExternalShop\Import\Contracts\ShopDriverInterface;

abstract class ShopDriver implements ShopDriverInterface
{
    const ORDER_STATUS_PROGRESS = 0;          // формируется/создается клиентом
    const ORDER_STATUS_NEW_PENDING = 1;       // новый заказ, в ожидании
    const ORDER_STATUS_STILL_PROCESSED = 2;   // обрабатывается
    const ORDER_STATUS_STILL_DELIVERED = 4;   // доставляется
    const ORDER_STATUS_DELIVERED = 6;         // доставлен
    const ORDER_STATUS_COMPLETED = 7;         // выполнен (оплачен, выполнен)
    const ORDER_STATUS_CANCELED = 8;          // отменен (менеджером магазина)
    const ORDER_STATUS_REJECTED = 9;          // отклонен (отказ клиена)
    const ORDER_STATUS_DRAFT = 10;            // черновой вариант
    const ORDER_STATUS_INDEFINED = 11;        // не определен

    public static function getStatuses(string $column = 'title', string $key = 'id')
    {
        $records = [
            ['id' => self::ORDER_STATUS_PROGRESS, 'title' => 'Формируется', 'lte_title' => '<small class="label label-default">Формируется</small>'],
            ['id' => self::ORDER_STATUS_NEW_PENDING, 'title' => 'Новый', 'lte_title' => '<small class="label label-primary">Новый</small>'],
            ['id' => self::ORDER_STATUS_STILL_PROCESSED, 'title' => 'Обрабатывается', 'lte_title' => '<small class="label label-warning">Обрабатывается</small>'],
            ['id' => self::ORDER_STATUS_STILL_DELIVERED, 'title' => 'Доставляется', 'lte_title' => '<small class="label label-warning">Доставляется</small>'],
            ['id' => self::ORDER_STATUS_DELIVERED, 'title' => 'Доставлен', 'lte_title' => '<small class="label label-success">Доставлен</small>'],
            ['id' => self::ORDER_STATUS_COMPLETED, 'title' => 'Выполнен', 'lte_title' => '<small class="label label-success">Выполнен</small>'],
            ['id' => self::ORDER_STATUS_CANCELED, 'title' => 'Отменен', 'lte_title' => '<small class="label label-danger">Отменен</small>'],
            ['id' => self::ORDER_STATUS_REJECTED, 'title' => 'Отклонен клиентом', 'lte_title' => '<small class="label label-danger">Отклонен клиентом</small>'],
            ['id' => self::ORDER_STATUS_DRAFT, 'title' => 'Черновой', 'lte_title' => '<small class="label label-default">Черновой</small>'],
            ['id' => self::ORDER_STATUS_INDEFINED, 'title' => 'Не определен', 'lte_title' => '<small class="label label-default">Не определен</small>'],
        ];

        return array_column($records, $column, $key);
    }
}
