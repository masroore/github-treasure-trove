<?php
/**
 * Created by PhpStorm.
 * User: its
 * Date: 31.01.19
 * Time: 12:18.
 */

namespace App\Helpers\ShoppingCart\StorageDrivers;

use App\Models\Shop\Order;
use App\Models\Shop\Product;
use App\Models\Shop\Value;
use Cart;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartEloquentStorageDriver implements CartStorageDriver
{
    protected $order;

    protected $uuid;

    protected $items;

    /**
     * CartEloquentStorageDriver constructor.
     */
    public function __construct()
    {
        if ($this->items === null) {
            if (auth()->user()) {
                $this->order = Order::firstOrCreate([
                    'user_id' => Cart::getCurrentUserId(), //TODO: session now is not best way!
                    'type' => Order::TYPE_CART,
                    'status' => 'order_new',            // TODO safe status
                    'payment_status' => 'payment_new',  // TODO safe status
                ]);
            } else {
                $this->uuid = Cookie::get('uuid') ?: Cookie::queue('uuid', Str::uuid(), 0);
                $this->order = Order::firstOrCreate([
                    'uuid' => $this->uuid,
                    'type' => Order::TYPE_CART,
                    'status' => 'order_new',            // TODO safe status
                    'payment_status' => 'payment_new',  // TODO safe status
                ]);
            }
            $this->items = $this->order->products;
        }
    }

    /**
     * Returns list of product ids.
     *
     * @return int[]
     */
    public function get()
    {
        return $this->items;
    }

    /**
     * Adds $amount product (s) with id $id.
     */
    public function add(int $id, int $amount = 1, ?int $color = null): void
    {
        if ($existingProduct = $this->order->products->where('id', $id)->where('pivot.value_id', $color)->first()) {
            $quantityInCart = $existingProduct->pivot->quantity;
            $this->order->products()->where('id', $id)->wherePivot('value_id', $color)->updateExistingPivot($id, [
                'quantity' => $quantityInCart + $amount,
            ]);

        // If not isset product in cart - set "quantity" = 1
        } elseif ($product = Product::where('id', $id)->first()) {
            $this->order->products()->attach([$id => [
                'quantity' => $amount,
                'value_id' => $color,
                'price' => $this->getCalculatePriceColor($product, $color),
            ]]);
        }

        if (isset($this->items)) {
            foreach ($this->items as $index => $item) {
                if ($item->id === $id && $item->pivot->value_id === $color) {
                    $item->pivot->quantity += $amount;
                } else {
                    $item->pivot->quantity = $amount;
                }
            }
        }
    }

    public function update(int $id, int $amount = 1, ?int $color = null): bool
    {

        // Check on the existence of product in the Order-cart
        // If isset product in cart - increment "quantity"
        if ($existingProduct = $this->order->products->where('id', $id)->where('pivot.value_id', $color)->first()) {
            if ($amount < 1 || $existingProduct->pivot->quantity < 1) {
                if ($this->items !== null) {
                    foreach ($this->items as $index => $item) {
                        if ($item->id === $id && $item->pivot->value_id === $color) {
                            $this->items->forget($index);
                        }
                    }
                }

                return $this->order->products()->where('id', $id)->wherePivot('value_id', $color)->detach($id);
            }

            $this->order->products()->wherePivot('value_id', $color)->updateExistingPivot($id, [
                'quantity' => $amount,
            ]);
        } elseif ($product = $this->order->products->where('id', $id)->where('pivot.value_id', $color)->first()) {
            $this->order->products()->wherePivot('value_id', $color)->attach([$id => [
                'quantity' => $amount,
                'value_id' => $color ? $color : 0,
                'price' => $this->getCalculatePrice('price'),
            ]]);
        }

        foreach ($this->items as $index => $item) {
            if ($item->id === $id && $item->pivot->value_id === $color) {
                $item->pivot->quantity = $amount;
                $item->save();
            }
        }

        return true;
    }

    /**
     * Removes $amount product (s) with id $id
     * If $amount is null, then the whole product is removed
     * Returns false if nothing has changed.
     */
    public function remove(int $id, ?int $amount = null, ?int $color = null): bool
    {
        // Check on the existence of product in the Order-cart
        // If isset product in cart - decrement "quantity" or attach all
        if ($existingProduct = $this->order->products->where('id', $id)->where('pivot.value_id', $color)->first()) {
            $quantityInCart = $existingProduct->pivot->quantity;
            if ($amount == 0 || $amount >= $quantityInCart) {
                if ($this->items !== null) {
                    unset($this->items[$id]);
                }

                return $this->items->products()->wherePivot('value_id', $color)->detach($id);
//                return true;
            }
            if ($this->items !== null) {
                $this->items->products()->wherePivot('value_id', $color)->sync($id, [
                    'quantity' => $quantityInCart - $amount,
                ], false);
//                    $this->items[$id] = $quantityInCart - $amount;
            }

            return $this->order->products()->wherePivot('value_id', $color)->updateExistingPivot($id, [
                'quantity' => $quantityInCart - $amount,
            ]) !== 0;
        }

        return false;
    }

    /**
     * Clear the cart
     * Returns false if cart was empty.
     */
    public function clear(): bool
    {
        $this->items = [];
        $this->order->products()->detach();

        return true;
    }

    public function getCalculatePriceColor(Product $product, $color)
    {
        if ($color) {
            $color = Value::findOrFail($color);
        }
        $price = $product->getCalculatePrice('price');
        if ($color) {
            $price = $price + ($price * $color->markup);

            return $price;
        }

        return $price;
    }
}
