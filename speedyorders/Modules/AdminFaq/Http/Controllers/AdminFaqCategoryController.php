<?php

namespace Modules\AdminFaq\Http\Controllers;

use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AdminFaq\Http\Requests\CreateAdminFaqCategoryrequest;
use Modules\AdminFaq\Http\Requests\UpdateAdminFaqCategoryrequest;
use Modules\AdminFaq\Imports\FaqCategoryImport;
use Modules\AdminFaq\Services\CreateFaqCategoryService;
use Modules\AdminFaq\Services\UpdateFaqCategoryService;

class AdminFaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = [
            'menu' => 'faq-categories',
        ];
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $faqcategory = FaqCategory::where('name', 'LIKE', "%$keyword%")
                ->orWhere('meta-tag', 'LIKE', "%$keyword%")
                ->orWhere('sort_order', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->orderByDesc('id')
                ->latest()->paginate($perPage);
        } else {
            $faqcategory = FaqCategory::orderByDesc('id')->latest()->paginate($perPage);
        }

        return view('adminfaq::category.index', compact('faqcategory'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = [
            'menu' => 'faq-categories',
        ];

        return view('adminfaq::category.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateAdminFaqCategoryrequest $request, CreateFaqCategoryService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Faq category stored successfully.');
        } else {
            session()->flash('error_message', 'Faq category could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.faq.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $data = [
            'menu' => 'faq-categories',
        ];
        $faqcategory = FaqCategory::findOrFail($id);

        return view('adminfaq::category.show', compact('faqcategory'), $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data = [
            'menu' => 'faq-categories',
        ];
        $faqcategory = FaqCategory::findOrFail($id);

        return view('adminfaq::category.edit', compact('faqcategory'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateAdminFaqCategoryrequest $request, $id, UpdateFaqCategoryService $service)
    {
        $requestData = $request->validated();

        $faqcategory = FaqCategory::findOrFail($id);

        if ($service->handle($validatedData, $id)) {
            session()->flash('success_message', 'Faq category updated successfully.');
        } else {
            session()->flash('success_message', 'Faq category couldn"t be updated.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.faq.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        FaqCategory::destroy($id);

        return redirect()->route('admin.faq.categories.index')->with('flash_message', 'FaqCategory deleted!');
    }

    public function updateFaqCatgeoryStatus($id)
    {
        try {
            $faqCategory = FaqCategory::find($id);
            if ('1' == $faqCategory->status) {
                $status = '0';
            } else {
                $status = '1';
            }
            FaqCategory::where('id', $id)->first()->update(['status' => $status]);
            session()->flash('success_message', 'Faq Category updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error_message', 'Faq Category could not be updated.');
        }

        return redirect()->route('admin.faq.categories.index');
    }

    public function importFromExcel(Request $request)
    {
        $request->validate([
            'faq_category_file'=>'required|file||mimes:csv,xlsx|max:4096',
        ]);

        if ($request->hasFile('faq_category_file')) {
            if (Excel::import(new FaqCategoryImport(), $request->file('faq_category_file'))) {
                session()->flash('success_message', 'Faq Category stored successfully.');
            } else {
                session()->flash('error_message', 'Faq Category could not be updated.');
            }
        } else {
            session()->flash('error_message', 'File has not been uploaded.');
        }

        return redirect()->route('admin.faq.categories.index');
    }
}
