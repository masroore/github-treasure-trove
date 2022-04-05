<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCommentRequest;
use App\Http\Resources\Control\PostCommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * TODO:.
 *
 * Class PostCommentController
 */
class PostCommentController extends Controller
{
    /**
     * @api {get} /api/v1/control/posts/{postId}/comments 01. Список
     * @apiVersion 1.0.0
     * @apiName GetPostCommentsList
     * @apiGroup 38.Блог: комментарии
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page] Количество элементов на странице
     */
    public function index(Request $request, Post $post)
    {
        $comments = $post->comments()
            ->orderByDesc('created_at')
            ->with('user')
            ->paginate($request->per_page);

        return PostCommentResource::collection($comments);
    }

    /**
     * @apiPrivate
     *
     * @api {post} /api/v1/control/posts/{postId}/comments 03. Сохранить
     * @apiVersion 1.0.0
     * @apiName PostPostCommentsStore
     * @apiGroup 38.Блог: комментарии
     */
    public function store(Post $post, PostCommentRequest $request)
    {
        $this->authorize('post-manage');

        $post->comments()->create($request->validated());

        return response()
            ->json(['message' => trans('system.actions.store.success')], Response::HTTP_CREATED);
    }

    /**
     * @apiPrivate
     *
     * @api {get} /api/v1/control/posts/{postId}/comments/{commentId}/edit 04. Редактировать
     * @apiVersion 1.0.0
     * @apiName GetPostCommentsEdit
     * @apiGroup 38.Блог: комментарии
     */
    public function edit(Comment $comment)
    {
        return PostCommentResource::make($comment);
    }

    /**
     * @apiPrivate
     *
     * @api {patch} /api/v1/control/posts/{postId}/comments/{commentId} 05. Обновить
     * @apiVersion 1.0.0
     * @apiName PatchPostCommentsUpdate
     * @apiGroup 38.Блог: комментарии
     */
    public function update(Comment $comment, PostCommentRequest $request)
    {
        $this->authorize('post-manage');

        $comment->update($request->validated());

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_ACCEPTED);
    }

    /**
     * @apiPrivate
     *
     * @api {delete} /api/v1/control/posts/{postId}/comments/{commentId} 06. Удалить
     * @apiVersion 1.0.0
     * @apiName DeletePostCommentsDestroy
     * @apiGroup 38.Блог: комментарии
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('post-manage');

        $comment->delete();

        return response()
            ->json(['message' => trans('system.actions.destroy.success')], Response::HTTP_OK);
    }
}
