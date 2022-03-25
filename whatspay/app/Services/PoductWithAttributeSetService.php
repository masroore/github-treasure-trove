<?php

namespace App\Services;

use App\Repositories\AttributeSetRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class PoductWithAttributeSetService
{
    /**
     * @var
     */
    protected $attributesetRepository;

    /**
     * AttributeSetService constructor.
     */
    public function __construct(
        AttributeSetRepositoryInterface $attributeSetRepository
    ) {
        $this->attributeSetRepository = $attributeSetRepository;
    }

    public function store(Request $request)
    {
        try {
            // get default store id from token
            $request['store_id'] = request()
                ->user()
                ->currentAccessToken()
                ->store_id;

            $validator = Validator::make($request->input(), [
                'title' => 'required|string|max:15|',
                'slug' => 'required|string|max:15|unique:product_attribute_sets,slug',
                'display_layout' => 'required|string|in:dropdown,visual,text',
                'order' => 'required|integer',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            // create data
            $attribute = $this->attributeSetRepository->create(
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $attribute;
    }

    public function update(Request $request, $id)
    {
        try {
            // get default store id from token
            $store_id = request()
                ->user()
                ->currentAccessToken()
                ->store_id;

            $validator = Validator::make($request->input(), [
                'title' => 'required|string|max:15|',
                'slug' => 'required|string|max:15|unique:product_attribute_sets,slug,' . $id,
                'display_layout' => 'required|string|in:dropdown,visual,text',
                'order' => 'required|integer',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            // update data
            $attribute = $this->attributeSetRepository->updateByColumn([
                'store_id' => $store_id,
                'id' => $id,
            ], $request->input());
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $attribute;
    }

    public function show($id)
    {
        try {
            // get default store id from token
            $store_id = request()
                ->user()
                ->currentAccessToken()
                ->store_id;

            // update data
            $attribute = $this->attributeSetRepository->findByColumn([
                'store_id' => $store_id,
                'id' => $id,
            ], ['id', 'title', 'slug', 'order']);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $attribute;
    }

    public function index()
    {
        try {
            // get default store id from token
            $store_id = request()
                ->user()
                ->currentAccessToken()
                ->store_id;

            // update data
            $attributes = $this->attributeSetRepository->findAllByColumn([
                'store_id' => $store_id,
            ], ['id', 'title', 'slug', 'order']);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $attributes;
    }

    public function destroy($id)
    {
        try {
            // get default store id from token
            $store_id = request()
                ->user()
                ->currentAccessToken()
                ->store_id;

            // update data
            $deleted = $this->attributeSetRepository->deleteByColumn([
                'store_id' => $store_id,
                'id' => $id,
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $deleted;
    }
}
