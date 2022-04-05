<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostUserStoreRequest;
use App\Http\Resources\PostUserResource;
use App\Models\PostUser;
use Illuminate\Http\Response;

class PostUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PostUserResource::collection(PostUser::all()->where('deleted', '<', 1));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PostUserStoreRequest $request)
    {
        $created_post_user = PostUser::create($request->validated());

        return new PostUserResource($created_post_user);
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
        return new PostUserResource(PostUser::where('deleted', '<', 1)->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PostUserStoreRequest $request, $id)
    {
        $post_user = PostUser::where('deleted', '<', 1)->findOrFail($id);
        $post_user->update($request->validated());

        return new PostUserResource($post_user);
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
        PostUser::findOrFail($id)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function delete($id)
    {
        $post_user = PostUser::findOrFail($id);
        $post_user->deleted = (int) !$post_user->deleted;
        $post_user->update();

        return $post_user;
    }
}
