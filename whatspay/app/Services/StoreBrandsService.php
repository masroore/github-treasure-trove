<?php

namespace App\Services;

use App\Models\StoreBrands;
use App\Repositories\Eloquent\StoreBrandsRepository;
use App\Repositories\Eloquent\StoreRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class StoreBrandsService
{
    /**
     * @var StoreBrandsRepository
     */
    protected $storeBrandsRepository;
    protected $storeRepository;

    public function __construct(
        StoreBrandsRepository $storeBrandsRepository,
        StoreRepository $storeRepository
    ) {
        $this->storeBrandsRepository = $storeBrandsRepository;
        $this->storeRepository = $storeRepository;
    }

    public function getAll(Request $request)
    {
        try {
            $storeBrands = $this->storeRepository->findById($request['store_id'], ['id'])->brands;
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $storeBrands;
    }

    public function store(Request $request)
    {
        try {
            // validate request
            $validate = Validator::make($request->input(), [
                'store_id' => 'required|integer',
                'brand_id' => 'required|integer',
                'status' => 'required|boolean',
            ]);

            if ($validate->fails()) {
                throw new InvalidArgumentException($validate->errors()->first());
            }

            $storeBrand = $this->storeBrandsRepository->updateGetModel([
                'store_id' => $request['store_id'],
                'brand_id' => $request['brand_id'],
            ], $request->input());
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $storeBrand;
    }

    public function updateMultiple(Request $request)
    {
        try {
            // validate request
            $validate = Validator::make($request->input(), [
                'ids' => 'required',
                'status' => 'required|boolean',
            ]);

            if ($validate->fails()) {
                throw new InvalidArgumentException($validate->errors()->first());
            }

            $ids = $request->ids;
            if (!\is_array($ids)) {
                $ids = explode(',', $ids);
            }

            $storeBrand = (new StoreBrands())->whereIn('id', $ids)
                ->where(['store_id' => $request['store_id']])
                ->update(['status' => $request->status]);

//            $storeBrand = $this->storeBrandsRepository
//                ->updateMultiple('id', $ids, [
//                    'status' => $request->status
//                ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $storeBrand;
    }
}
