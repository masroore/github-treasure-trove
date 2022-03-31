<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Request $request)
    {
    }

    // Header Pages

    public function store()
    {
        $activePage = 'store';

        return view('store.index', compact('activePage'));
    }

    public function promotions()
    {
        $activePage = 'promotions';

        return view('pages.promotions', compact('activePage'));
    }

    public function trendings()
    {
        $activePage = 'trendings';

        return view('pages.trendings', compact('activePage'));
    }

    public function b2b_home()
    {
        $activePage = 'b2b_home';

        return view('pages.b2b_home', compact('activePage'));
    }

    // Dynamic Pages

    public function wishlist()
    {
        $activePage = 'Pin List';

        return view('pages.wishlist', compact('activePage'));
    }

    public function support()
    {
        $supportCategories = Faq::leftjoin('faq_categories', 'faq_categories.id', '=', 'faqs.faq_category_id')
            ->where('type', 'support')->select('faq_categories.id', 'faq_categories.name')->groupBy('faq_categories.id')->get();

        $cat_index = 0;
        foreach ($supportCategories as &$category) {
            $supports = Faq::leftjoin('faq_categories', 'faq_categories.id', '=', 'faqs.faq_category_id')
                ->where('type', 'support')
                ->where('faq_category_id', $category->id)
                ->get();

            if (\count($supports) > 0) {
                $category->questions = $supports;
            }

            $cat_index++;
        }

        $activePage = 'support';

        return view('pages.support', compact('activePage', 'supportCategories'));
    }

    public function faq()
    {
        $faqCategories = Faq::leftjoin('faq_categories', 'faq_categories.id', '=', 'faqs.faq_category_id')
            ->where('type', 'faq')->select('faq_categories.id', 'faq_categories.name')->groupBy('faq_categories.id')->get();

        $cat_index = 0;
        foreach ($faqCategories as &$category) {
            $faqs = Faq::leftjoin('faq_categories', 'faq_categories.id', '=', 'faqs.faq_category_id')
                ->where('type', 'faq')
                ->where('faq_category_id', $category->id)
                ->get();

            if (\count($faqs) > 0) {
                $category->questions = $faqs;
            }

            $cat_index++;
        }

        $activePage = 'FAQ';

        return view('pages.faq', compact('activePage', 'faqCategories'));
    }

    public function site_map()
    {
        $activePage = 'Site Map';

        return view('pages.site_map', compact('activePage'));
    }

    // All static pages
    public function getCmsPageDetails(Request $request, $slug)
    {
        $activePage = $slug;

        $page_data = Page::where('slug', $slug)->first();
        $content = $page_data->content;
        $title = $page_data->title;

        return view('pages.index', compact('activePage', 'content', 'title'));
    }
}
