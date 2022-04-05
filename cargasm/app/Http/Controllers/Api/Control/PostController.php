<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Control\PostRequest;
use App\Http\Requests\Control\SeoRequest;
use App\Http\Requests\SyncRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\Control\LanguageResource;
use App\Http\Resources\Control\PostEditResource;
use App\Http\Resources\Control\PostResource;
use App\Http\Resources\Control\SeoModelEditResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Variable;

class PostController extends Controller
{
    /**
     * @api {get} /api/v1/control/posts 01. Список постов
     * @apiVersion 1.0.0
     * @apiName GetPostIndex
     * @apiGroup 37.Блог
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page] Количество элементов на странице
     * @apiParam {String=id,title,created_at} [sort=created_at] Поле для сортировки
     * @apiParam {String=asc,desc} [direction=desc] Направление сортировки
     * @apiParam {String} [_lang] Фильтрация по языку
     *
     * @apiParam {String} [q] Поисковый запрос
     *
     * @apiParam {Array} [f] Поля для фильтрации. См. ниже:
     * @apiParam(f) {Integer} [user_id] Партнер, создавшый запись
     */
    public function index(Request $request)
    {
        $this->authorize('post-manage');

        $posts = Post::sortable('created_at')
            ->filterable()
            ->searchable()
            ->with('author')
            ->where('post_type', Post::TYPE_BLOG)
            ->paginate($request->per_page);

        return PostResource::collection($posts)
            ->additional([
                'form' => $this->getFormAdditional(),
            ]);
    }

    /**
     * @api {get} /api/v1/control/news 10. Получение новостей
     * @apiVersion 1.0.0
     * @apiName GetPostsNews
     * @apiGroup 37.Блог
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page] Количество элементов на странице
     * @apiParam {String=id,title,created_at} [sort=created_at] Поле для сортировки
     * @apiParam {String=asc,desc} [direction=desc] Направление сортировки
     * @apiParam {String} [_lang] Фильтрация по языку
     *
     * @apiParam {String} [q] Поисковый запрос
     *
     * @apiParam {Array} [f] Поля для фильтрации. См. ниже:
     * @apiParam(f) {Integer} [user_id] Партнер, создавшый запись
     */
    public function getNews(Request $request)
    {
        $this->authorize('post-manage');

        $posts = Post::sortable('created_at')
            ->filterable()
            ->searchable()
            ->with('author')
            ->where('post_type', Post::TYPE_NEWS)
            ->paginate($request->per_page);

        return PostResource::collection($posts)
            ->additional([
                'form' => $this->getNewsFormAdditional(),
            ]);
    }

    /**
     * @api {get} /api/v1/control/posts/create 02. Создать (форма)
     * @apiVersion 1.0.0
     * @apiName GetPostCreate
     * @apiGroup 37.Блог
     */
    public function create()
    {
        return response()->json([
            'form' => $this->getFormAdditional(),
        ]);
    }

    /**
     * @api {post} /api/v1/control/posts 03. Сохранить
     * @apiVersion 1.0.0
     * @apiName PostPostStore
     * @apiGroup 37.Блог
     *
     * @apiParam {String} lang Язык
     * @apiParam {String} title Заголовок
     * @apiParam {String} text Текст
     * @apiParam {String} [slug] Slug (алиас)
     * @apiParam {String} status Статус
     * @apiParam {String} msg_reject Комментарий к модерации
     * @apiParam {String=news,blog} [post_type] Тип поста
     * @apiParam {Boolean} comment_allowed Разрешить комментарии
     * @apiParam {Int} user_id ID пользователя, создавшого пост (и соотв. автора, если не указан service_id)
     * @apiParam {Int} [service_id] Id СТО (если атор поста - СТО)
     *
     * @apiParam {Array} media_deleted ID удаления media
     * @apiParam {Array} photo Фото
     *
     * @apiParamExample {json} Request-Example:
     * "photo": {
     *        "id": null,
     *        "file": "<BINARY FILE>",
     *        "title": "File title",
     *        "alt": "File alt",
     *        "is_active": true,
     *        "is_main": true,
     *        "delete": false,
     * }
     */
    public function store(PostRequest $request)
    {
        $this->authorize('post-manage');

        /** @var Post $post */
        $post = Post::create($request->only([
            'title', 'slug', 'text', 'comment_allowed', 'status', 'post_type', 'lang',
            'msg_reject', 'user_id', 'author_type', 'author_id',
        ]));
        $post->mediaManage($request);

        return response()
            ->json(['message' => trans('system.actions.store.success')], Response::HTTP_CREATED);
    }

    /**
     * @api {post} /api/v1/control/posts/{postId}/edit 04. Редактировать
     * @apiVersion 1.0.0
     * @apiName GetPostEdit
     * @apiGroup 37.Блог
     */
    public function edit(Post $post)
    {
        return PostEditResource::make($post->load('media', 'author', 'user'))->additional([
            'form' => $this->getFormAdditional(),
        ]);
    }

    /**
     * @api {patch} /api/v1/control/posts/{postId} 05. Обновить
     * @apiVersion 1.0.0
     * @apiName PatchPostUpdate
     * @apiGroup 37.Блог
     */
    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('post-manage');

        $post->update($request->only([
            'title', 'slug', 'text', 'comment_allowed', 'status', 'post_type', 'lang',
            'msg_reject', 'user_id', 'author_type', 'author_id',
        ]));
        $post->mediaManage($request);

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_ACCEPTED);
    }

    /**
     * @api {delete} /api/v1/control/posts/{postId} 06. Удалить
     * @apiVersion 1.0.0
     * @apiName DeletePostDestroy
     * @apiGroup 37.Блог
     */
    public function destroy(Post $post)
    {
        $this->authorize('post-manage');
        $post->comments()->delete();
        $post->likes()->delete();
        $post->favorites()->delete();
        $post->shares()->delete();
        $post->timelines()->delete();

        $post->delete();

        return response()
            ->json(['message' => trans('system.actions.destroy.success')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/control/posts/sync 07. Синхронизация записей
     * @apiVersion 1.0.0
     * @apiName PostPostSync
     * @apiGroup 37.Блог
     *
     * @apiDescription Метод позволяет масово изменять, добавлять, удалять записи.
     *
     * @apiParam {Array} [deleted] Массив ID-дов для удаления.
     * @apiParam {Array} [changed] Массив обьектов записей и их полей для изменения.
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *          "deleted": [4711, 234]
     *     }
     */
    public function sync(SyncRequest $request)
    {
        $this->authorize('post-manage');

        if ($request->deleted) {
            Post::whereIn('id', $request->deleted)->delete();
        }

        if ($request->changed) {
            foreach ($request->changed as $item) {
                if (isset($item['id']) && ($model = Post::find($item['id']))) {
                    //$model->update(\Arr::only($item, 'is_active'));
                }
            }
        }

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_OK);
    }

    protected function getFormAdditional(): array
    {
        return [
            'statuses' => Post::statusesList(),
            'types' => Post::typesList(),
            'languages' => LanguageResource::collection(get_languages()),
        ];
    }

    protected function getNewsFormAdditional(): array
    {
        return [
            'statuses' => Post::statusesList(),
            'languages' => LanguageResource::collection(get_languages()),
        ];
    }

    /**
     * @api {get} /api/v1/control/posts/{postId}/seo 08. Редактировать SEO
     * @apiVersion 1.0.0
     * @apiName GetPostSeoEdit
     * @apiGroup 37.Блог
     */
    public function seoEdit(Post $post)
    {
        return (new SeoModelEditResource($post))
            ->additional([
                'form' => [
                    'tokens' => Variable::setLang($post->lang)->getArray('seo_masks')[$post->post_type]['tokens'] ?? [],
                ],
            ]);
    }

    /**
     * @api {post} /api/v1/control/posts/{postId}/seo 09. Сохранить SEO
     * @apiVersion 1.0.0
     * @apiName PatchPostSeoSave
     * @apiGroup 37.Блог
     *
     * @apiParam {String} [title] Title
     * @apiParam {String} [keywords] Keywords
     * @apiParam {String} [description] Description
     * @apiParam {String=index,noindex} [robots] Robots
     */
    public function seoSave(SeoRequest $request, Post $post)
    {
        $this->authorize('post-manage');
        $post->seo()->updateOrCreate([], $request->validated());

        return response()
            ->json(['message' => trans('system.actions.update.success')], \Illuminate\Http\Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/control/posts/{id}/comments 10. Получение коментариев к посту
     * @apiVersion 1.0.0
     * @apiName getPostComment
     * @apiGroup 37.Блог
     */
    public function getPostComments(Request $request, Post $post)
    {
        $comments = Comment::getChildTreeArray($post->comments()->with('user')->withCount('likes')->orderBy('created_at')->get());

        return CommentResource::collection($comments);
    }
}
