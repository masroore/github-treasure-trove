<?php

namespace App\Services;

use App\Repositories\BrandsRepositoryInterface;
use App\Repositories\StoreRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class BrandsService
{
    /**
     * @var
     */
    protected $brandsRepository;
    protected $storeRepository;

    /**
     * CategoryService constructor.
     *
     * @param BrandsRepository $brandsRepository
     */
    public function __construct(
        BrandsRepositoryInterface $brandsRepository,
        StoreRepositoryInterface $storeRepository
    ) {
        $this->brandsRepository = $brandsRepository;
        $this->storeRepository = $storeRepository;
    }

    /**
     * Get all Categories of a user.
     */
    public function getAll()
    {
        try {
            $brands = $this->brandsRepository->findAllByPagination([]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $brands;
    }

    public function store(Request $request)
    {
        try {

            // validate request
            $validator = Validator::make($request->input(), [
                'name' => 'required|string',
                'description' => 'required',
                'website' => 'required',
                'status' => 'required',
                'is_featured' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            if ($request->hasFile('logo')) {
                $name = onefile($request->logo, 'storage/uploads/store/brands', $request->name);
                $request['logo'] = $name;
            }

            $address = $this->brandsRepository->create(
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $address;
    }

    public function show($brand_id)
    {
        try {
            $category = $this->brandsRepository->findByColumn([
                'id' => $brand_id,
            ], [
                'id',
                'name',
                'description',
                'website',
                'logo',
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
            $address = $this->brandsRepository->deleteByIds($ids);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $address;
    }

    public function destroy($id)
    {
        try {
            $address = $this->brandsRepository->deleteById($id);
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
                'description' => 'required',
                'website' => 'required',
                'status' => 'required',
                'is_featured' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            if ($request->hasFile('logo')) {
                $name = onefile($request->image, 'storage/uploads/store/brands', $request->name);
                $request['logo'] = $name;
            }

            return $this->brandsRepository->update(
                $id,
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}
