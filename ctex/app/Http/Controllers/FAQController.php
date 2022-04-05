<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class FAQController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $locale = app()->getLocale();

        $category_list = [];
        $faq_list = [];

        try {
            $category_list = FaqCategory::where('lang', $locale)
                ->orderby('id', 'asc')
                ->get()->toArray();

            if (isset($category_list[0])) {
                $faq_list = Faq::where('lang', $locale)
                    ->where('category', $category_list[0]['id'])
                    ->get()->toArray();
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());
        }
        $data['category_list'] = $category_list;
        $data['faq_list'] = $faq_list;

        return view('faq', $data);
    }

    /**
     * get faq list from id.
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getFaqList($id)
    {
        $locale = app()->getLocale();

        $faq_list = [];

        try {
            $category_list = FaqCategory::where('lang', $locale)
                ->orderby('id', 'asc')
                ->get()->toArray();

            $faq_list = Faq::where('lang', $locale)
                ->where('category', $id)
                ->orderby('rank', 'asc')
                ->get()->toArray();
        } catch (QueryException $e) {
            Log::error($e->getMessage());
        }

        $data['category_id'] = $id;
        $data['category_list'] = $category_list;
        $data['faq_list'] = $faq_list;

        return view('faq', $data);
    }
}
