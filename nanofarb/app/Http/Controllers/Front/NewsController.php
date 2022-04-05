<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $nodes = News::isPublish()->orderBy('created_at', 'desc')->byLocale()->paginate();

        return view('front.news.index', compact('nodes'));
    }

    public function show($id)
    {
        $node = News::isPublish()->findOrFail($id);

        return view('front.news.show', compact('node'));
    }
}
