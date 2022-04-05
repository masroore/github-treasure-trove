<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Admin\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class PageController extends Controller
{
    /**
     * Adding auth middleware to this controller.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa', 'is_admin']);
    }

    /**
     * Displaying the Pages Manager page.
     */
    public function index()
    {
        $pages = Page::all();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Add a New Page.
     */
    public function add()
    {
        return view('admin.pages.add');
    }

    /**
     * Display the Edit page.
     *
     * @param model $page
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Delete a Page.
     */
    public function delete(Page $page, Request $request)
    {
        if (!$request->confirm) {
            laraflash(Lang::get('alerts.admin.pages.invalid_request'), Lang::get('alerts.sorry'))->danger();

            return redirect()->route('admin.pages.index');
        }

        $page->delete();

        laraflash(Lang::get('alerts.admin.pages.deleted_success'), Lang::get('alerts.success'))->success();

        return redirect()->route('admin.pages.index');
    }
}
