<?php

namespace App\Services;

use App\Repositories\Eloquent\ShippingCompaniesRepository;
use App\Repositories\ShippingCompaniesRepositoryInterface;
use App\Repositories\StoreRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class ShippingCompaniesService
{
    /**
     * @var
     */
    protected $shippingcompaniesRepository;

    protected $storeRepository;

    /**
     * CategoryService constructor.
     *
     * @param ShippingCompaniesRepository $shippingcompaniesRepository
     */
    public function __construct(
        ShippingCompaniesRepositoryInterface $shippingcompaniesRepository,
        StoreRepositoryInterface $storeRepository
    ) {
        $this->shippingcompaniesRepository = $shippingcompaniesRepository;
        $this->storeRepository = $storeRepository;
    }

    /**
     * Get all Categories of a user.
     */
    public function getAll(Request $request)
    {
        try {
            $categories = $this->shippingcompaniesRepository->findAllByPagination([
                'store_id' => $request['store_id'],
            ], [
                'id',
                'store_id',
                'image',
                'shipping_service',
                'company_url',
                'tracking_url',
                'address',
                'country',
                'state',
                'city',
                'postal_code',
                'email',
                'status',
                'is_featured',
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $categories;
    }

    public function store(Request $request)
    {
        try {

            // validate request
            $validator = Validator::make($request->input(), [
                'shipping_service' => 'required',
                'company_url' => 'required|string',
                'tracking_url' => 'required',
                'address' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'postal_code' => 'required',
                'email' => 'required',
                'status' => 'required',
                'is_featured' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            if ($request->hasFile('image')) {
                $name = onefile($request->image, 'storage/uploads/store/shippingcompanies', $request->shipping_service);
                $request['image'] = $name;
            }

            $address = $this->shippingcompaniesRepository->create(
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $address;
    }

    public function show(Request $request, $id)
    {
        try {
            $category = $this->shippingcompaniesRepository->findByColumn([
                'id' => $id,
                'store_id' => $request['store_id'],
            ], [
                'image',
                'shipping_service',
                'company_url',
                'tracking_url',
                'address',
                'country',
                'state',
                'city',
                'postal_code',
                'email',
                'description',
                'status',
                'is_featured',
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $category;
    }

    public function destorybulk(Request $request)
    {
        try {
            $ids = $request['ids'];
            $ids = explode(',', $ids);
            $address = $this->shippingcompaniesRepository->deleteByIds($ids);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $address;
    }

    public function destroy(Request $request)
    {
        try {
            $ids = $request->input('ids');

            // if not array convert
            if (!\is_array($ids)) {
                $ids = explode(',', $ids);
            }

            $deleted = $this->shippingcompaniesRepository->deleteByIds($ids);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $deleted;
    }

    public function update(Request $request, $id)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'shipping_service' => 'required|string',
                'company_url' => 'required',
                'tracking_url' => 'required',
                'address' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'postal_code' => 'required',
                'email' => 'required',
                'description' => 'required',
                'status' => 'required',
                'is_featured' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            if ($request->hasFile('image')) {
                $name = onefile($request->image, 'storage/uploads/store/shippingcompanies', $request->shipping_service);
                $request['image'] = $name;
            }

            return $this->shippingcompaniesRepository->update(
                $id,
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * update Shipping Companies status.
     *
     * @return $message
     */
    public function status(Request $request, $id)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'status' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $updated = $this->shippingcompaniesRepository->updateByColumn([
                'id' => $id,
                'store_id' => $request['store_id'],
            ], $request->except('store_id'));
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $updated;
    }
}
