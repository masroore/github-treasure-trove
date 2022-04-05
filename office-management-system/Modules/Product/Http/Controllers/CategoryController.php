<?php

namespace Modules\Product\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LogActivity;
use Modules\Product\Http\Requests\CategoryFormRequest;
use Modules\Product\Repositories\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        try {
            $categories = $this->categoryRepository->all();

            return view('product::category.category', [
                'categories' => $categories,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function parent_category()
    {
        return $this->categoryRepository->all();
    }

    public function getALl()
    {
        return $this->categoryRepository->all();
    }

    public function allSubCategory()
    {
        return $this->categoryRepository->allSubCategory();
    }

    public function create(Request $request)
    {
        try {
            $search_keyword = null;
            if ($request->input('search_keyword') != null) {
                $search_keyword = $request->input('search_keyword');
                $categories = $this->categoryRepository->serachBased($search_keyword);
            } else {
                $categories = $this->categoryRepository->all();
            }

            return view('product::category.category_list', [
                'categories' => $categories,
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function store(CategoryFormRequest $request)
    {
        try {
            $this->categoryRepository->create($request->except('_token'));

            return response()->json(['message' => 'Category Added Successfully'], 200);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['message' => 'Something Went Wrong', 'error' => $e->getMessage()], 503);
        }
    }

    public function edit($id)
    {
        try {
            return $this->categoryRepository->find($id);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->categoryRepository->update($request->except('_token'), $id);

            return response()->json(['message' => 'Category Updated Successfully'], 200);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            return response()->json(['message' => 'Something Went Wrong', 'error' => $e->getMessage()], 503);
        }
    }

    public function destroy($id)
    {
        try {
            $this->categoryRepository->delete($id);
            Toastr::success('Category Deleted Successfully');

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::success('Something Went Wrong');

            return back();
        }
    }
}
