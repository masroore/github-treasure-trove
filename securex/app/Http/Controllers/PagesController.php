<?php

namespace App\Http\Controllers;

use App\Models\Admin\Page;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    /**
     * Return the custom page view.
     */
    public function view(Page $page)
    {
        if ($page->status == 'Draft') {
            if (!Auth::check() || !auth()->user()->isAdmin()) {
                abort(404);
            }
        }

        return view('pages.view', compact('page'));
    }
}
