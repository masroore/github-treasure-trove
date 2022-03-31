<?php

namespace Modules\AdminPage\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AdminPage\Http\Requests\CreateAdminPageRequest;
use Modules\AdminPage\Http\Requests\UpdateAdminPageRequest;
use Modules\AdminPage\Services\CreatePageService;
use Modules\AdminPage\Services\UpdatePageService;

class AdminPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = [
            'menu' => 'pages',
        ];

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $adminpage = Page::where('parent_id', 'LIKE', "%$keyword%")
                ->orWhere('slug', 'LIKE', "%$keyword%")
                ->orWhere('title', 'LIKE', "%$keyword%")
                ->orWhere('content', 'LIKE', "%$keyword%")
                ->orWhere('main_image', 'LIKE', "%$keyword%")
                ->orWhere('main_video', 'LIKE', "%$keyword%")
                ->orWhere('seo', 'LIKE', "%$keyword%")
                ->orWhere('seo_description', 'LIKE', "%$keyword%")
                ->orWhere('sort_order', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->with('page')
                ->orderByDesc('id')
                ->get();
        } else {
            $adminpage = Page::with('page')->orderByDesc('id')->get();
        }

        return view('adminpage::index', compact('adminpage'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = [
            'menu' => 'pages',
        ];
        $pages = Page::get();

        return view('adminpage::create', compact('pages'), $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateAdminPageRequest $request, CreatePageService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Page stored successfully.');
        } else {
            session()->flash('error_message', 'Page could not be stored.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.pages.index');
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
        $adminpage = Page::findOrFail($id);

        return view('adminpage::show', compact('adminpage'));
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
            'menu' => 'pages',
        ];
        $adminpage = Page::findOrFail($id);
        $pages = Page::get();

        return view('adminpage::edit', compact('adminpage', 'pages'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateAdminPageRequest $request, $id, UpdatePageService $service)
    {
        $requestData = $request->validated();

        if ($service->handle($requestData, $id)) {
            session()->flash('success_message', 'Page updated successfully.');
        } else {
            session()->flash('error_message', 'Page could not be updated.');

            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.pages.index');
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
        Page::destroy($id);

        return redirect()->route('admin.pages.index')->with('flash_message', 'Page deleted!');
    }
}
