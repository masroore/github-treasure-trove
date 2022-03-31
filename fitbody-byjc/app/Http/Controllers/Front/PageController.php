<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Back\Custom\Project;
use App\Models\Front\Category\Category;
use App\Models\Front\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * @param Category $subcat
     * @param Page     $page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Category $cat, $subcat = null, ?Page $page = null)
    {
        // Ako je samo $cat.
        if (!$subcat && !$page) {
            if ($cat->single_page) {
                $page = Page::published()->article($cat)->first();

                if (!$page) {
                    abort(401);
                }

                $page->setDescription();

                return view('front.page.single', compact('cat', 'page'));
            }

            $pages = Page::published()->news($cat)->latest()->paginate(config('settings.pagination.items'));

            return view('front.page.list', compact('cat', 'subcat', 'pages'));
        }

        // Provjeri je li $subcat kategorija ili page.
        $subcategory = Category::where('slug', $subcat)->first();

        // Ako je subcategory i page.
        if ($subcat && $page) {
            $subcat = $subcategory;
            $page->setDescription();

            return view('front.page.single', compact('cat', 'subcat', 'page'));
        }

        // Ako nema page.
        if ($subcat && !$page) {
            // Ako subcategory nije kategorija.
            // Provjeri je li page.
            if (!$subcategory) {
                $page = Page::where('slug', $subcat)->first();

                if (!$page) {
                    abort(401);
                }

                $page->setDescription();

                return view('front.page.single', compact('cat', 'page'));
            }

            // Ako je subcategory kategorija
            $subcat = $subcategory;
            if ($subcat->single_page) {
                $page = Page::published()->article($subcat)->first();

                if (!$page) {
                    abort(401);
                }

                $page->setDescription();

                return view('front.page.single', compact('cat', 'page'));
            }

            $pages = Page::published()->news($subcat)->latest()->paginate(config('settings.pagination.items'));

            return view('front.page.list', compact('cat', 'subcat', 'pages'));
        }

        return abort(401);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function projectList(Request $request)
    {
        $projects = Project::all();
        $count = $projects->count();
        $sum = number_format($projects->sum('amount'), 2, ',', '.');
        $projects = $projects->groupBy('year');

        //dd($projects);

        return view('front.page.project-list', compact('projects', 'count', 'sum'));
    }
}
