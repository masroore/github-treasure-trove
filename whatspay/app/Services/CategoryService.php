<?php

namespace App\Services;

use App\Models\Products;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\StoreRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class CategoryService
{
    /**
     * @var
     */
    protected $categoryRepository;

    protected $storeRepository;

    protected $productRepository;

    /**
     * CategoryService constructor.
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        StoreRepositoryInterface $storeRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->storeRepository = $storeRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Get all Categories of a user.
     */
    public function getAll()
    {
        try {
            $store_id = request()
                ->user()
                ->currentAccessToken()
                ->store_id;
            $categories = $this->categoryRepository->findAllByPagination([
                'store_id' => $store_id,
            ], [
                'id',
                'parent_id',
                'store_id',
                'name',
                'icon',
                'description',
                'image',
                'status',
            ], ['subcategories']);
            // var_dump($categories);
            // exit();
            //$collection = new Collection($categories);

            // Paginate

            $perPage = 5; // Item per page

            // $currentPage = 0;

            //$pagedData = $collection->slice($currentPage * $perPage, $perPage)->all();
            //  var_dump($pagedData);
            //  exit();

            // $pagination = new Paginator($categories, $perPage);
            // var_dump($pagination);
            // exit();

        //   $categories->links();
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
                'store_id' => 'required',
                'name' => 'required|string',
                'status' => 'required',
                'is_featured' => 'required',
                'parent_id' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            if ($request->hasFile('image')) {
                $name = onefile($request->image, 'storage/uploads/store/categories', $request->name);
                $request['image'] = $name;
            }
            // dd($request->input());

            // update previous default address
            // if($request['is_default']) {
            //     $this->addressRepository->updateByColumn(
            //         ['user_id' => Auth::user()->id], [
            //             'is_default' => 0
            //         ]
            //     );
            // }

            // $request['user_id'] = Auth::user()->id;

            $address = $this->categoryRepository->create(
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $address;
    }

    public function show($categoryid)
    {
        try {
            $store_id = request()
                ->user()
                ->currentAccessToken()
                ->store_id;
            $category = $this->categoryRepository->findByColumn([
                'id' => $categoryid,
                'store_id' => $store_id,
            ], [
                'parent_id',
                'store_id',
                'icon',
                'description',
                'image',
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
            $address = $this->categoryRepository->deleteByIds($ids);
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

            $deleted = $this->categoryRepository->deleteByIds($ids);
//            $address = $this->categoryRepository->deleteById($id);
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
                'name' => 'required|string',
                'status' => 'required',
                'is_featured' => 'required',
                'parent_id' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            if ($request->hasFile('image')) {
                $name = onefile($request->image, 'storage/uploads/store/categories', $request->name);
                $request['image'] = $name;
            }

            return $this->categoryRepository->update(
                $id,
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    public function changeStatus(Request $request, $id)
    {
        try {

            // validate request
            $validator = Validator::make($request->input(), [
                'status' => 'required|in:0,1',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            return $this->categoryRepository->update(
                $id,
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    public function productMigration(Request $request): void
    {
        try {
//            dd($request->except('store_id'));
            foreach ($request->except('store_id') as $value) {
//                dd(Products::update([
//                    'category_id' => $value['to']
//                ])->where(['category_id' => $value['from']]));
                $this->productRepository->updateByColumn([
                    'category_id' => $value['from'],
                ], [
                    'category_id' => $value['to'],
                ]);
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}
