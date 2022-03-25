<?php

namespace App\Services;

use App\Repositories\ProductLabelsRepositoryInterface;
use App\Repositories\StoreRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class ProductLabelsService
{
    /**
     * @var
     */
    protected $productlabelsRepository;
    protected $storeRepository;

    public function __construct(
        ProductLabelsRepositoryInterface $productlabelsRepository,
        StoreRepositoryInterface $storeRepository
    ) {
        $this->productlabelsRepository = $productlabelsRepository;
        $this->storeRepository = $storeRepository;
    }

    /**
     * Get all Categories of a user.
     */
    public function getAll()
    {
        try {
            $brands = $this->productlabelsRepository->findAllByPagination([]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $brands;
    }

    public function store(Request $request)
    {
        try {
//            dd($request->input());
            // validate request
            $validator = Validator::make($request->input(), [
                'name' => 'required|string',
                'color' => 'required',
                'status' => 'required',
                'store_id' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            if ($request->hasFile('logo')) {
                $name = onefile($request->logo, 'storage/uploads/store/brands', $request->name);
                $request['logo'] = $name;
            }

            $address = $this->productlabelsRepository->create(
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $address;
    }

    public function show($label_id)
    {
        try {
            $category = $this->productlabelsRepository->findByColumn([
                'id' => $label_id,
            ], [
                'id',
                'name',
                'color',
                'status',
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
            $address = $this->productlabelsRepository->deleteByIds($ids);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $address;
    }

    public function destroy($id)
    {
        try {
            $address = $this->productlabelsRepository->deleteById($id);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $address;
    }

    public function update(Request $request, $id)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'name' => 'required|string',
                'color' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            return $this->productlabelsRepository->update(
                $id,
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}
