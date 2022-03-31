<?php

namespace Modules\AdminCategory\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\AdminCategory\Http\Requests\CreateCategoryRequest;
use Modules\AdminCategory\Http\Requests\ImportCategoryRequest;
use Modules\AdminCategory\Http\Requests\UpdateCategoryRequest;
use Modules\AdminCategory\Services\CreateCategoryService;
use Modules\AdminCategory\Services\ImportCategoryService;
use Modules\AdminCategory\Services\UpdateCategoryService;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'menu' => 'categories',
        ];

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $categories = Category::where('category_id', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('slug', 'LIKE', "%$keyword%")
                ->orWhere('image', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->orderByDesc('id')
                ->get();
        } else {
            $categories = Category::all();
        }

        return view('admincategory::index', compact('categories'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $data = [
            'menu' => 'categories',
        ];
        $categories = Category::latest()->get();

        return view('admincategory::create', compact('categories'), $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(CreateCategoryRequest $request, CreateCategoryService $service)
    {
        $validatedDatas = $request->validated();

        if ($service->handle($validatedDatas)) {
            session()->flash('success_message', 'Category stored successfully.');
        } else {
            session()->flash('error_message', 'Category could not be stored.');
        }

        return redirect()->route('admin.categories.index');
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
        $data = [
            'menu' => 'categories',
        ];

        $category = Category::findOrFail($id);

        return view('admincategory::show', compact('category'), $data);
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
            'menu' => 'categories',
        ];

        $category = Category::findOrFail($id);
        $categories = Category::latest()->get();

        return view('admincategory::edit', ['category'=>$category, 'categories'=>$categories], $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(UpdateCategoryRequest $request, $id, UpdateCategoryService $service)
    {
        $category = Category::findOrFail($id);

        $validatedDatas = $request->validated();

        if ($service->handle($validatedDatas, $id)) {
            session()->flash('success_message', 'Category updated successfully.');
        } else {
            session()->flash('error_message', 'Category could not be updated.');
        }

        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        try {
            Category::destroy($id);
            session()->flash('success_message', 'Product deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error_message', 'Product could not be deleted.');
        }

        return redirect()->route('admin.categories.index');
    }

    public function updateCategoryStatus($id)
    {
        try {
            $category = Category::find($id);
            if ('1' == $category->status) {
                $status = '0';
            } else {
                $status = '1';
            }
            Category::where('id', $id)->first()->update(['status' => $status]);
            session()->flash('success_message', 'Category updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error_message', 'Category could not be updated.');
        }

        return redirect()->route('admin.categories.index');
    }

    /**
     * Import the products from csv file.
     *
     * @return Response
     */
    public function import()
    {
        $data = [
            'menu' => 'categories',
        ];

        return view('admincategory::import');
    }

    /**
     * import all the csv products in to the DB table products and related tables.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function importData(ImportCategoryRequest $request, ImportCategoryService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Categories imported successfully.');
        } else {
            session()->flash('error_message', 'Categories imported could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.categories.index');
    }
}
