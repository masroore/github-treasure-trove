<?php

namespace Modules\Product\Repositories;

use Modules\Product\Entities\Coupon;

class CouponRepository implements CouponRepositoryInterface
{
    public function all()
    {
        return Coupon::latest()->get();
    }

    public function create(array $data): void
    {
        $variant = new Coupon();
        $variant->fill($data)->save();
    }

    public function find($id)
    {
        return Coupon::findOrFail($id);
    }

    public function update(array $data, $id): void
    {
        $variant = Coupon::findOrFail($id);
        $variant->update($data);
    }

    public function delete($id)
    {
        return Coupon::findOrFail($id)->delete();
    }
}
