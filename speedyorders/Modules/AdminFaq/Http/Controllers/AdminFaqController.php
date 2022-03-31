<?php

namespace Modules\AdminFaq\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AdminFaq\Http\Requests\CreateFaqRequest;
use Modules\AdminFaq\Http\Requests\UpdateFaqRequest;
use Modules\AdminFaq\Imports\FaqImport;
use Modules\AdminFaq\Services\CreateFaqService;
use Modules\AdminFaq\Services\UpdateFaqService;

class AdminFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = [
            'menu' => 'faqs',
        ];

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $faq = Faq::where('faq_category_id', 'LIKE', "%$keyword%")
                ->with('faqCategory')
                ->orWhere('question', 'LIKE', "%$keyword%")
                ->orWhere('type', 'LIKE', "%$keyword%")
                ->orWhere('answer', 'LIKE', "%$keyword%")
                ->orWhere('sort_order', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->orderByDesc('id')
                ->latest()->paginate($perPage);
        } else {
            $faq = Faq::with('faqCategory')->orderByDesc('id')->latest()->paginate($perPage);
        }

        return view('adminfaq::index', compact('faq'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = [
            'menu' => 'faqs',
        ];
        $categories = FaqCategory::where('status', 1)->get();

        return view('adminfaq::create', compact('categories'), $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateFaqRequest $request, CreateFaqService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Faq stored successfully.');
        } else {
            session()->flash('error_message', 'Faq could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.faqs.index');
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
            'menu' => 'faqs',
        ];
        $faq = Faq::findOrFail($id);

        return view('adminfaq::show', compact('faq'), $data);
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
            'menu' => 'faqs',
        ];
        $faq = Faq::findOrFail($id);
        $categories = FaqCategory::where('status', 1)->get();

        return view('adminfaq::edit', compact('faq', 'categories'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateFaqRequest $request, $id, UpdateFaqService $service)
    {
        $faq = Faq::findOrFail($id);
        $validatedData = $request->validated();

        if ($service->handle($validatedData, $id)) {
            session()->flash('success_message', 'Faq updated successfully.');
        } else {
            session()->flash('success_message', 'Faq couldn"t be updated.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.faqs.index');
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
        Faq::destroy($id);

        return redirect()->route('admin.faqs.index')->with('flash_message', 'Faq deleted!');
    }

    public function updateFaqStatus($id)
    {
        try {
            $faq = Faq::find($id);
            if ('1' == $faq->status) {
                $status = '0';
            } else {
                $status = '1';
            }
            Faq::where('id', $id)->first()->update(['status' => $status]);
            session()->flash('success_message', 'Faq updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error_message', 'Faq could not be updated.');
        }

        return redirect()->route('admin.faqs.index');
    }

    public function importFromExcel(Request $request)
    {
        $request->validate([
            'faq_file'=>'required|file||mimes:csv,xlsx|max:4096',
        ]);

        if ($request->hasFile('faq_file')) {
            if (Excel::import(new FaqImport(), $request->file('faq_file'))) {
                session()->flash('success_message', 'Faq stored successfully.');
            } else {
                session()->flash('error_message', 'Faq could not be updated.');
            }
        } else {
            session()->flash('error_message', 'File has not been uploaded.');
        }

        return redirect()->route('admin.faqs.index');
    }
}
