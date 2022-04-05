<?php

namespace App\Services;

use App\Repositories\BranchRepositoryInterface;
use App\Repositories\StoreRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class BranchService
{
    /**
     * @var BranchRepositoryInterface
     */
    protected $storeRepository;

    protected $branchRepository;

    public function __construct(StoreRepositoryInterface $storeRepository, BranchRepositoryInterface $branchRepository)
    {
        $this->storeRepository = $storeRepository;
        $this->branchRepository = $branchRepository;
    }

    /**
     * Manage Branch.
     *
     * @return Collection $branches
     */
    public function getAll(Request $request)
    {
        try {
            $branches = $this->branchRepository->findAllByColumn([
                'parent_branch_id' => $request['store_id'],
            ], [
                'id',
                'store_logo',
                'store_name',
                'whatsapp_num',
                'business_url',
                'email',
                'street_address',
                'latitude',
                'longitude',
                'country',
                'city',
                'state',
                'status',
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $branches;
    }

    /**
     * Show Branch.
     *
     * @return $message
     */
    public function show(Request $request, $id)
    {
        try {
            $branch = $this->branchRepository->findByColumn([
                'id' => $id,
                'parent_branch_id' => $request['store_id'],
            ], [
                'id',
                'store_name',
                'whatsapp_num',
                'email',
                'street_address',
                'postal_code',
                'area',
                'city',
                'state',
                'country',
                'latitude',
                'longitude',
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $branch;
    }

    /**
     * Create branch.
     *
     * @return $message
     */
    public function store(Request $request)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'store_name' => 'required|string',
                'whatsapp_num' => 'required|string|unique:stores,whatsapp_num',
                'email' => 'required|email',
                'street_address' => 'required|string',
                'postal_code' => 'required|string',
                'area' => 'required|string',
                'city' => 'required|string',
                'country' => 'required|string',
                'latitude' => 'required|string',
                'longitude' => 'required|string',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }
            $name = slugify($request['store_name']);
//            var_dump($name);
//            dd($request['store_id']);
            $request['user_id'] = Auth::user()->id;
            $request['parent_branch_id'] = $request['store_id'];
            $request['business_url'] = $request['store_id'] . '::' . $name;
//            dd($request->input());
//            $store_business_url = $this->branchRepository->findByColumn(['id' => $request['store_id']],[
//                'business_url',
//            ]);
//            $business_url  = $store_business_url->business_url;

            $branch = $this->branchRepository->create($request->input());
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $branch->only([
            'id',
            'store_logo',
            'store_name',
            'whatsapp_num',
            'business_url',
            'email',
            'street_address',
            'latitude',
            'longitude',
            'country',
            'city',
            'state',
            'status',
        ]);
    }

    /**
     * delete branch.
     *
     * @return $message
     */
    public function destroy(Request $request, $id)
    {
        try {
            $deleted = $this->branchRepository->deleteByColumn([
                'id' => $id,
                'parent_branch_id' => $request['store_id'],
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $deleted;
    }

    /**
     * Update Branch.
     *
     * @return $message
     */
    public function update(Request $request, $id)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'store_name' => 'required|string',
                'whatsapp_num' => 'required|string|unique:stores,whatsapp_num,' . $id,
                'email' => 'required|email',
                'street_address' => 'required|string',
                'postal_code' => 'required|string',
                'area' => 'required|string',
                'city' => 'required|string',
                'country' => 'required|string',
                'latitude' => 'required|string',
                'longitude' => 'required|string',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $name = slugify($request['store_name']);
            $request['user_id'] = Auth::user()->id;
//            $request['parent_branch_id'] = $request['store_id'];
            $request['business_url'] = $request['store_id'] . '::' . $name;

            $updated = $this->branchRepository->updateByColumn([
                'id' => $id,
                'parent_branch_id' => $request['store_id'],
            ], $request->except('store_id'));
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $updated;
    }

    /**
     * update branch status.
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

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $updated = $this->branchRepository->updateByColumn([
                'id' => $id,
                'parent_branch_id' => $request['store_id'],
            ], $request->except('store_id'));
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $updated;
    }

    public function validateSettings($request)
    {
        $rules = [
            'cash_on_delivery' => 'in:enable,disable',
            'currency' => 'in:PKR,USD,AED',
            'shipping_percentage_type' => 'in:flat,percentage',
            'shipping_percentage' => 'integer',
            'applicable_range' => 'integer',
            // 'delivery_days' => 'required',
            'delivery_hours' => 'integer',
            'delivery_minutes' => 'integer',
            //            'delivery_range' => 'required',
            'delivery_radius' => 'in:0,1',
            'disount_type' => 'in:flat,percentage',
            'discount_amount' => 'integer',
            //            'service_options' => 'required',
            'orders_accept_status' => 'in:yes,no',
            'is_tax_enable' => 'in:0,1',
            'tax_rate' => 'integer',
            'is_tax_included' => 'in:0,1',
            'custom_tax_config' => 'in:0,1',
            'allow_checkout_when_out_of_stock' => 'in:0,1',
            'min_order_price' => 'integer',
            'max_order_price' => 'integer',
            'min_order_qty' => 'integer',
            'max_order_qty' => 'integer',
        ];

        // validate request
        return Validator::make($request->json()->all(), $rules);
//        return Validator::make($request->input(), $rules);
    }

    /**
     * update store Branch settings.
     *
     * @param $id
     */
    public function updateSettings(Request $request, $id)
    {
        try {
            // validate request
            $validator = $this->validateSettings($request);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }
//            dd($request['store_id']);
            // update
            $this->branchRepository->updateByColumn([
                'user_id' => Auth::user()->id,
                'id' => $id,
                'parent_branch_id' => $request['store_id'],
            ], $request->except(['store_id']));
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return [];
    }

    /**
     * Update Store Timings.
     *
     * @param $request
     *
     * @return $message
     */
    public function storeTimings(Request $request, $id)
    {
        try {
            $result = $this->storeRepository->updateByColumn([
                'id' => $id,
                'parent_branch_id' => $request['store_id'],
            ], [
                'store_timings' => json_encode($request->except(['store_id'])),
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}
