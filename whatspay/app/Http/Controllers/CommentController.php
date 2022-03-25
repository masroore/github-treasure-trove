<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\Comment;
use App\Services\CommentService;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;

class CommentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */

    /**
     * @var CommentService
     */
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function storeComments(Request $request)
    {
        try {
            $request['commentable_type'] = 'App\Models\Store';
            $comment = $this->commentService->store($request);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $this->sendResponse($comment, 'Comment Added Successully');
    }

    public function productComments(Request $request)
    {
        try {
            $request['commentable_type'] = 'App\Models\Products';
            $comment = $this->commentService->store($request);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $this->sendResponse($comment, 'Comment Added Successully');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function showStoreComments($id)
    {
        try {
            $comments = $this->commentService->showStores($id);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $this->sendResponse($comments, 'Data found');
    }

    public function showProductComments($id)
    {
        try {
            $comments = $this->commentService->showProducts($id);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $this->sendResponse($comments, 'Data found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function edit(Comment $comment)
    {

    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $comments = $this->commentService->update($request, $id);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $this->sendResponse([], 'Comment Updated Successfully', $comments);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\jsonResponse
     */
    public function destroy($id)
    {
        try {
            $comments = $this->commentService->destroy($id);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $this->sendResponse([], 'Comment Deleted Successfully', $comments);
    }

    public function like(Request $request)
    {
        try {
            $like = $this->commentService->like($request);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $this->sendResponse([], 'liked Successfully');
    }
}
