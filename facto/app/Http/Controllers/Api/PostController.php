<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Cat;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->key == 'max-family') {
            $hours = $request->hours ?? 1;
            $cat_id = $request->cat_id ?? 1;
            $posts = Post::query()
                ->where('cat_id', $cat_id)
                ->whereBetween('created_at', [
                    now()->subhours($hours)->toDateTimeString(),
                    now()->toDatetimeString(),
                ])
                ->orderBy('created_at', 'asc')
                ->get();

            // return new PostCollection($posts->keyBy->id);
            // return response()->json();
            return PostResource::collection($posts->keyBy->id)
                ->additional([
                    'cat' => Cat::find($cat_id),
                ]);
        }

        return response()->json([]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
