<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
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
        try {
            $locale = app()->getLocale();

            $count = News::where('lang', $locale)->get()->count();

            $data['count'] = $count;
        } catch (QueryException $e) {
            Log::error($e->getMessage());
        }

        return view('news', $data);
    }

    /**
     * get news list.
     */
    public function getNewsList(Request $request): void
    {
        $page = $request->input('page');

        $page_count = config('constants.page_num');
        $skip = ($page - 1) * $page_count;

        $locale = app()->getLocale();

        $news_list = [];

        try {
            $news_list = News::where('lang', $locale)
                ->where('status', config('constants.news_status.valid'))
                ->orderby('updated_at', 'desc')
                ->skip($skip)
                ->take($page_count)->get()
                ->toArray();
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            echo json_encode($news_list);
            exit;
        }

        echo json_encode($news_list);
    }

    /**
     * news detail.
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function newsDetail($id)
    {
        try {
            $news_detail = News::where('id', $id)->first();
            if (null === $news_detail) {
                return redirect()->back()->withErrors(['failed' => trans('news.no_content_msg')]);
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withErrors(['failed' => trans('news.no_content_msg')]);
        }

        $data = $news_detail->toArray();

        return view('newsdetail', $data);
    }
}
