<?php

namespace App\Services;

use App\Repositories\AttributeRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class AttributeService
{
    /**
     * @var
     */
    protected $attributeRepository;

    /**
     * AttributeSetService constructor.
     */
    public function __construct(
        AttributeRepositoryInterface $attributeRepository
    ) {
        $this->attributeRepository = $attributeRepository;
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'title' => 'required|string|max:15|',
                'slug' => 'required|string|max:15|unique:product_attributes,slug',
                'color' => 'required|string',
                'attribute_set_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }
            if ($request->hasFile('image')) {
                $name = onefile($request->image, 'storage/uploads/store/attribute', $request->slug);
                $request['image'] = $name;
            }
            // create data
            $attribute = $this->attributeRepository->create(
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $attribute;
    }

    public function update(Request $request, $id)
    {

//        dd($request);
        try {
            $validator = Validator::make($request->input(), [
                'title' => 'required|string|max:15|',
                'slug' => 'required|string|max:15|unique:product_attributes,slug,' . $id,
                'color' => 'required|string',
                'attribute_set_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }
            if ($request->hasFile('image')) {
                $name = onefile($request->image, 'storage/uploads/store/attribute', $request->slug);
                $request['image'] = $name;
            }
            // update data
            $attribute = $this->attributeRepository->updateByColumn([
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
            $attribute = $this->attributeRepository->findByColumn(['id' => $id]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $attribute;
    }

    public function index($id)
    {
        try {
            // update data
            $attributes = $this->attributeRepository->findAllByColumn(
                ['attribute_set_id' => $id]
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $attributes;
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->attributeRepository->deleteByColumn([
                'id' => $id,
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $deleted;
    }
}
