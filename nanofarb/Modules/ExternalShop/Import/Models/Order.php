<?php

namespace Modules\ExternalShop\Import\Models;

/**
 * Class Order.
 *
 * @property int $id
 * @property string $number
 * @property Client $client
 * @property string $status
 * @property array|Purchase $purchases
 */
final class Order extends Model
{
    //...
}
