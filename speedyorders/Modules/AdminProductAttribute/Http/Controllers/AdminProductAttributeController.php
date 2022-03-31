<?php

namespace Modules\AdminProductAttribute\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Log;
use Modules\AdminProductAttribute\Http\Requests\CreateAdminProductAttributeRequest;
use Modules\AdminProductAttribute\Http\Requests\UpdateAdminProductAttributeRequest;
use Modules\AdminProductAttribute\Services\CreateAdminProductAttributeService;
use Modules\AdminProductAttribute\Services\UpdateAdminProductAttributeService;

class AdminProductAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'menu' => 'attributes',
        ];

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $attributes = Attribute::where('attribute_label', 'LIKE', "%$keyword%")
                ->with('attributeValues')
                ->orderByDesc('id')
                ->get();
        } else {
            $attributes = Attribute::with('attributeValues')->orderByDesc('id')->get();
        }

        return view('adminproductattribute::index', compact('attributes'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [
            'menu' => 'attributes',
        ];

        return view('adminproductattribute::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(CreateAdminProductAttributeRequest $request, CreateAdminProductAttributeService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Product Attribute information added stored successfully.');
        } else {
            session()->flash('error_message', 'Product Attribute could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.product.attributes.index');
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return view('adminproductattribute::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'menu' => 'attributes',
        ];
        $attribute = Attribute::where('id', $id)->with('attributeValues')->first();

        return view('adminproductattribute::edit', compact('attribute'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(UpdateAdminProductAttributeRequest $request, $id, UpdateAdminProductAttributeService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData, $id)) {
            session()->flash('success_message', 'Product Attribute updated successfully.');
        } else {
            session()->flash('error_message', 'Product Attribute could not be updated.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.product.attributes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function delete($id)
    {
        try {
            Attribute::find($id)->delete();
            session()->flash('success_message', 'Product Attribute deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error_message', 'Product Attribute could not be deleted.');
        }

        return redirect()->route('admin.product.attributes.index');
    }

    public function importFromCsv(Request $request)
    {
        try {

           // DB::beginTransaction();

            $validatedData = $request->all();

            $fileName = '';
            if (isset($validatedData['attribute_file'])) {
                $file_name = $validatedData['attribute_file'];
                $fileName =
                    uniqid() .
                    time() .
                    '.' .
                    $file_name->getClientOriginalExtension();
                $file_name->move(public_path('images/attributes'), $fileName);
                $validatedData['attribute_file'] = $fileName;
            }

            // Now parse the csv and store all values in DB
            $filename = public_path('images/attributes/' . $fileName);

            $list_attributes = [];
            if (($file = @fopen($filename, 'r')) !== false) {
                $count_header = 0;

                while (($data = @fgetcsv($file, 10000, ',')) !== false) {
                    if ($count_header > 0 && !empty($data)) {
                        $attribute_label = (isset($data[0])) ? $data[0] : '';
                        $input_type = (isset($data[1])) ? $data[1] : '';
                        $is_required = (isset($data[2])) ? $data[2] : '';
                        $attribute_code = (isset($data[3])) ? $data[3] : '';
                        $include_in_filter = (isset($data[4])) ? $data[4] : '';
                        $attribute_values = (isset($data[5]) && '' != $data[5]) ? explode('::', $data[5]) : '';

                        // check if attribute already exists

                        if ($attribute_label && '' != $attribute_label) {
                            Log::info('this is 1 : ' . $count_header);

                            $attribute_data = Attribute::where('attribute_label', $attribute_label)->first();

                            $list_attributes[] = $attribute_label;

                            if (!empty($attribute_data)) {
                                Log::info('this is attribute_data : ' . $count_header);
                                $attribute_id = $attribute_data['id'];
                            } else {
                                Log::info('this is attr : ' . $count_header);
                                $attribute = new Attribute();

                                $attribute->attribute_label = $attribute_label;
                                $attribute->input_type = $input_type;
                                $attribute->is_required = $is_required;
                                $attribute->attribute_code = $attribute_code;
                                $attribute->include_in_filter = $include_in_filter;
                                $attribute->created_at = now();
                                $attribute->save();

                                $attribute_id = $attribute->id;
                            }

                            if (!empty($attribute_values)) {
                                Log::info('this is attribute_values : ' . $count_header);
                                foreach ($attribute_values as $attribute_value) {
                                    Log::info('this is attribute_values : ' . $count_header . ' => ' . $attribute_value);

                                    $attribute_values_Data = AttributeValue::where('attributes_id', $attribute_id)->where('name', $attribute_value)->first();

                                    if (empty($attribute_values_Data) && '' != $attribute_value) {
                                        $attributeValue = new AttributeValue();
                                        $attributeValue->attributes_id = $attribute_id;
                                        $attributeValue->name = $attribute_value;
                                        $attributeValue->save();
                                    }
                                }
                            }
                        }
                    }

                    $count_header++;
                }
            }
            // DB::commit();

            session()->flash('success_message', 'Product Attributes imported successfully.');

            return redirect()->route('admin.product.attributes.index');
        } catch (\Exception $e) {
            Log::info('Error' . $e->getMessage());
            Log::info('Line Number' . $e->getLine());
            DB::rollback();

            session()->flash('error_message', $e->getMessage());

            return redirect()->route('admin.product.attributes.index');

            // return false;
        }
    }
}
