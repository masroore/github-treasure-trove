<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Complaint\PostComplaintRequest;
use App\Http\Requests\FilterUserPostsRequest;
use App\Http\Requests\PostChangeStatus;
use App\Http\Requests\PostCommentAddRequest;
use App\Http\Requests\PostGetAllRequest;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostCleanResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostShowResource;
use App\Http\Resources\PostShowUserResource;
use App\Http\Resources\SeoModelResource;
use App\Models\Comment;
use App\Models\Notify;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\Timeline;
use App\Models\User;
use App\Notifications\Post\NewComment;
use App\Notifications\Post\NewLike;
use App\Notifications\Post\NewShare;
use App\Notifications\Post\PostComplaint;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show', 'getUserPosts', 'getPostComments', 'getNews']);
    }

    /**
     * @api {get} /api/v1/posts 1. Получение статей блога
     * @apiVersion 1.0.0
     * @apiName BlogIndex
     * @apiGroup 06.Блог
     *
     * @apiDescription Получение статей блога.
     *
     * @apiParam {String} type Тип постов <code>blog, news</code>
     * @apiParam {String} [sort] Сортировка постов доступные значение <code>date, comment, like</code>
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function index(PostGetAllRequest $request)
    {
        $posts = Post::with('media', 'user', 'author', 'shares')->withCount('likes', 'comments', 'favorites')
            ->where('status', Post::POST_PUBLISHED)
            ->where('post_type', $request->type === Post::TYPE_BLOG ? Post::TYPE_BLOG : Post::TYPE_NEWS)
            ->filter($request->sort)
            ->paginate($request->per_page);

        return PostResource::collection($posts);
    }

    /**
     * @api {get} /api/v1/news 16. Получение новостей
     * @apiVersion 1.0.0
     * @apiName BlogNews
     * @apiGroup 06.Блог
     *
     * @apiDescription Получение новостей.
     *
     * @apiParam {String} lang Код языка
     * @apiParam {String} [sort] Сортировка постов доступные значение <code>date, comment, like</code>
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function getNews(Request $request)
    {
//        $user = auth()->user();
        $posts = Post::with('media', 'user', 'author', 'shares')->withCount('likes', 'comments', 'favorites')
//            ->whereHas('user')
            ->where('status', Post::POST_PUBLISHED)
//            ->where('lang', $request->lang)
            ->where('post_type', Post::TYPE_NEWS)
            ->filter($request->sort)
            ->paginate($request->per_page);

        return PostResource::collection($posts);
    }

    /**
     * @api {get} /api/v1/posts/{id} 2. Получение статьи
     * @apiVersion 1.0.0
     * @apiName BlogShow
     * @apiGroup 06.Блог
     *
     * @apiDescription Получение статьи блога.
     */
    public function show($slug)
    {
        $post = Post::with('media', 'author', 'translations', 'shares')
            ->withCount('likes', 'comments', 'favorites')
            ->where('slug', $slug)->firstOrFail();

        return PostShowResource::make($post)->additional([
            'seo' => new SeoModelResource($post),
        ]);
    }

    protected function createPost($request, $uuid = false)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->role === User::ROLE_ADMIN || $user->role === User::ROLE_PARTNER) {
            $post = Post::create(array_merge(
                Arr::except($request->validated(), 'main_photo'),
                [
                    'status' => $request->status,
                    'uuid' => $uuid ? $uuid : Str::uuid()->toString(),
                    'post_type' => $user->role === User::ROLE_ADMIN ? $request->post_type : Post::TYPE_BLOG,
                    'lang' => $request->lang,
                    'author_type' => $request->author_type == 'user' ? 'App\Models\User' : 'App\Models\Service',
                    'author_id' => $request->author_id,
                    'user_id' => $user->id,
                ]
            ));
        } else {
            /** @var Post $post */
            $post = $user->posts()->create(array_merge(
                Arr::except($request->validated(), 'main_photo'),
                [
                    'status' => $request->status,
                    'uuid' => $uuid ? $uuid : Str::uuid()->toString(),
                    'post_type' => Post::TYPE_BLOG,
                    'lang' => $request->lang,
                    'user_id' => $user->id,
                    'author_type' => 'App\Models\User',
                    'author_id' => $user->id,
                ]
            ));
        }

        if ($request->hasFile('main_photo.file')) {
            $post->mediaSave([
                'file' => $request->main_photo['file'],
                'is_main' => true,
            ], 'photo');
        }

        if ($post->status === Post::POST_PUBLISHED) {
            $post->timelines()->create([
                'user_id' => $user->id,
                'type' => Timeline::TYPE_ADD,
            ]);
        }

        return $post;
    }

    protected function createPostTranslation($uuid, $post, $lang): void
    {
        PostTranslation::create([
            'uuid' => $uuid ? $uuid : $post->uuid,
            'post_translated_id' => $post->id,
            'language' => $lang,
        ]);
    }

    /**
     * @api {post} /api/v1/posts 4. Добавление статьи
     * @apiVersion 1.0.0
     * @apiName BlogStore
     * @apiGroup 06.Блог
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} lang Аббревиатура языка на котором создается пост
     * @apiParam {File} main_photo Главное фото
     * @apiParam {String} title Заголовок
     * @apiParam {String} text Текст
     * @apiParam {String} [status] Сохранить статью в черновик, <code>draft</code>
     * @apiParam {String} [author_type] Тип автора поста (использовать когда юзер имеет роль <code>PARTNER</code>)
     * @apiParam {Int} [author_id] Id автора (использовать когда юзер имеет роль <code>PARTNER</code>) <code>author_type и author_id</code> брать из запроса <code>.../user/authors </code>
     * @apiParam {String} [post_type] Тип поста. Доступные значение <code>news, blog<code> (использовать когда юзер имеет роль <code>ADMIN</code>)
     * @apiParam {Boolean} comment_allowed Разрешены ли комментарии?
     */
    public function store(PostStoreRequest $request)
    {
        $post = $this->createPost($request);
        $this->createPostTranslation(false, $post, $request->lang);
        $post->load('translations');

        return response()->json(['message' => trans('system.post.success'), 'post' => PostCleanResource::make($post)], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/posts/translate 5. Добавление перевода для статьи
     * @apiVersion 1.0.0
     * @apiName BlogStoreTransition
     * @apiGroup 06.Блог
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} lang Аббревиатура языка на котором создается пост
     * @apiParam {File} main_photo Главное фото
     * @apiParam {String} title Заголовок
     * @apiParam {String} text Текст
     * @apiParam {String} [status] Сохранить статью в черновик, <code>draft</code>
     * @apiParam {String} [author_type] Тип автора поста (использовать когда юзер имеет роль <code>PARTNER</code>)
     * @apiParam {Int} [author_id] Id автора (использовать когда юзер имеет роль <code>PARTNER</code>) <code>author_type и author_id</code> брать из запроса <code>.../user/authors </code>
     * @apiParam {String} [post_type] Тип поста. Доступные значение <code>news, blog<code> (использовать когда юзер имеет роль <code>ADMIN</code>)
     * @apiParam {Boolean} comment_allowed Разрешены ли комментарии?
     * @apiParam {int} parent_id Id "родительського" поста для которой создается перевод
     */
    public function addTransition(PostStoreRequest $request)
    {
        $this->validate($request, ['parent_id' => 'required']);
        $parentPost = Post::findOrFail($request->parent_id);

        if ($parentPost->checkIssetTranslate($request->lang)) {
            return response()->json(['messages' => trans('system.translation.isset')], Response::HTTP_BAD_REQUEST);
        }

        $post = $this->createPost($request, $parentPost->uuid);
        $this->createPostTranslation($parentPost->uuid, $post, $request->lang);
        $post->load('translations');

        return response()->json(['message' => trans('system.post.moderate'), 'post' => PostCleanResource::make($post)], Response::HTTP_OK);
    }

    /**
     * @api {put/patch} /api/v1/posts/{id} 6. Обновление поста
     * @apiVersion 1.0.0
     * @apiName BlogUpdate
     * @apiGroup 06.Блог
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {File} [main_photo] Главное фото
     * @apiParam {String} title Заголовок
     * @apiParam {String} text Текст
     * @apiParam {String} [author_type] Тип автора поста (использовать когда юзер имеет роль <code>partner</code>)
     * @apiParam {Int} [author_id] Id автора (использовать когда юзер имеет роль <code>partner</code>) <code>author_type и author_id<code> брать из запроса <code>/api/v1/user/authors </code>
     * @apiParam {String} [post_type] Тип поста. Доступные значение <code>news, blog<code> (использовать когда юзер имеет роль <code>admin</code>)
     * @apiParam {Boolean} comment_allowed Разрешены ли комментарии?
     */
    public function update($id, UpdatePostRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $post = Post::with('media', 'user', 'author', 'timelines')->findOrFail($id);

        if (Gate::allows('update-post', $post)) {
            if ($user->role === User::ROLE_ADMIN || $user->role === User::ROLE_PARTNER) {
                $post->update(array_merge(
                    Arr::except($request->validated(), ['main_photo', 'lang']),
                    [
                        'status' => $request->status,
                        'post_type' => $user->role === User::ROLE_ADMIN ? $request->post_type : Post::TYPE_BLOG,
                        'author_type' => $request->author_type == 'user' ? 'App\Models\User' : 'App\Models\Service',
                        'author_id' => $request->author_id,
                    ]
                ));
            } else {
                $post->update(array_merge(
                    $request->except(['author_type', 'author_id']),
                    [
                        'post_type' => Post::TYPE_BLOG,
                        'status' => $request->status,
                        'author_type' => 'App\Models\User',
                        'author_id' => $post->user->id,
                    ]
                ));
            }

            if ($request->hasFile('main_photo.file')) {
                $post->clearMediaCollection('photo');
                $post->mediaSave([
                    'file' => $request->main_photo['file'],
                    'is_main' => true,
                ], 'photo');
            }

            if (!$request->main_photo) {
                $post->clearMediaCollection('photo');
            }

            if ($post->status === Post::POST_PUBLISHED) {
                $post->timelines()->updateOrCreate([
                    'user_id' => $user->id,
                    'type' => Timeline::TYPE_UPDATE,
                ]);
            } else {
                $post->timelines()->delete();
            }

            return response()->json(['message' => trans('system.post.success'), 'post' => PostCleanResource::make($post)], Response::HTTP_OK);
        }

        return response()->json(['message' => trans('system.post.denies')], Response::HTTP_FORBIDDEN);
    }

    /**
     * @api {delete} /api/v1/posts/{id} 7. Удаление поста
     * @apiVersion 1.0.0
     * @apiName BlogDelete
     * @apiGroup 06.Блог
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (Gate::allows('delete-post', $post)) {
            $post->comments()->delete();
            $post->likes()->delete();
            $post->favorites()->delete();
            $post->shares()->delete();
            $post->timelines()->delete();
            $post->delete();

            return response()->json(['message' => trans('system.post.delete')], Response::HTTP_OK);
        }

        return response()->json(['message' => trans('system.post.denies')], Response::HTTP_FORBIDDEN);
    }

    /**
     * @api {get} /api/v1/users/{id}/posts 8. Получение статей юзера
     * @apiVersion 1.0.0
     * @apiName BlogUsersPosts
     * @apiGroup 06.Блог
     *
     * @apiParam {String} filter Получить статьи юзера по фильтру. Доступные значение <code>published, moderate, unpublished, draft</code>
     * @apiParam {String} [author] Доступное значение <code>user</code>. Выведет посты только юзера без СТО
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function getUserPosts($id, FilterUserPostsRequest $request)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        $posts = Post::with('media', 'author', 'translations', 'shares')->withCount('likes', 'comments')
            ->author($request->author, $user->id)
            ->whereIn('status', $request->filter == 'moderate' ? [Post::POST_MODERATE, Post::POST_REJECTED] : [$request->filter])
            ->sortPost($request->filter)
            ->paginate($request->per_page);

        return PostShowUserResource::collection($posts);
    }

    /**
     * @api {get} /api/v1/posts/{id}/comments 3. Получение коментариев к посту
     * @apiVersion 1.0.0
     * @apiName getPostComment
     * @apiGroup 06.Блог
     */
    public function getPostComments($id)
    {
        $post = Post::findOrFail($id);
        $comments = Comment::getChildTreeArray($post->comments()->with('user')->withCount('likes')->orderBy('created_at')->get());

        return CommentResource::collection($comments);
    }

    /**
     * @api {get} /api/v1/posts/{id}/change 9. Изминение статуса поста
     * @apiVersion 1.0.0
     * @apiName BlogChangeStatus
     * @apiGroup 06.Блог
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} status Изменить статус. Доступные значение <code>published, unpublished</code>
     */
    public function changeStatus($id, PostChangeStatus $request)
    {
        /** @var Post $post */
        $post = Post::findOrFail($id);

        if (Gate::allows('update-post', $post)) {
            $post->update([
                'status' => $request->status,
            ]);

            if ($post->status === Post::POST_PUBLISHED) {
                $post->timelines()->updateOrCreate([
                    'user_id' => $post->user->id,
                    'type' => Timeline::TYPE_UPDATE,
                ]);
            } else {
                $post->timelines()->delete();
            }

            return response()->json(['message' => trans('system.post.status'), 'post' => PostCleanResource::make($post)], Response::HTTP_OK);
        }

        return response()->json(['message' => trans('system.post.denies')], Response::HTTP_FORBIDDEN);
    }

    /**
     * @api {post} /api/v1/posts/{id}/like 10. Лайкнуть пост
     * @apiVersion 1.0.0
     * @apiName LikeAdd
     * @apiGroup 06.Блог
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function getLike($id)
    {
        $post = Post::with('user')->findOrFail($id);
        $user = auth()->user();

        if (!$post) {
            return response()
                ->json(['message' => 'Post Not Found'], Response::HTTP_NOT_FOUND);
        }

        if ($user->hasLikedPost($post)) {
            $post->likes()->delete();
            $post->notifies()->delete();

            return response()
                ->json(['message' => trans('system.like.delete')], Response::HTTP_OK);
        }

        $like = $post->likes()->create(['user_id' => $user->id]);
        Notification::send($post->user, new NewLike($post, $like, $user));
        $post->notifies()->create([
            'user_id' => $user->id,
            'type' => Notify::TYPE_LIKE,
            'text' => trans('notification.blog.like.add'),
        ]);

        return response()
            ->json(['message' => trans('system.like.save')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/posts/{id}/comment 11. Добавить коментарий к посту
     * @apiVersion 1.0.0
     * @apiName CommentAdd
     * @apiGroup 06.Блог
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {int} [parent_id] Id родительского коментария (если нет радителя - <code>null</code>)
     * @apiParam {int} post_id Id поста
     * @apiParam {String} text Текст коментария
     */
    public function comment($id, PostCommentAddRequest $request)
    {
        $post = Post::with('user')->findOrFail($id);
        $user = $request->user();

        if (!$post->allowComment()) {
            return response()->json(['message' => trans('system.comment.permission')], Response::HTTP_BAD_REQUEST);
        }

        $comment = $post->comments()->create([
            'user_id' => $user->id,
            'text' => $request->text,
        ]);

        if ($comment->commentable->user_id != $user->id) {
            Notification::send($post->user, new NewComment($post, $comment));
            $post->notifies()->create([
                'user_id' => $user->id,
                'type' => Notify::TYPE_COMMENT,
                'text' => trans('notification.comment.add'),
            ]);
        }

        return response()->json(['message' => trans('system.comment.save'), 'comment' => CommentResource::make($comment)], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/posts/{id}/favorite 13. Добавить/удалить из избранного
     * @apiVersion 1.0.0
     * @apiName Favorites
     * @apiGroup 06.Блог
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function favorite($id)
    {
        /** @var User $user */
        $user = auth()->user();
        $post = Post::findOrFail($id);

        if ($user->hasFavoritePost($post)) {
            $post->favorites()->delete();

            return response()->json(['message' => trans('system.favorite.remove')], Response::HTTP_OK);
        }

        $post->favorites()->create(['user_id' => $user->id]);

        return response()->json(['message' => trans('system.favorite.add')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/posts/{id}/share 14. Поделиться постом
     * @apiVersion 1.0.0
     * @apiName SharePost
     * @apiGroup 06.Блог
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function share($id, Request $request)
    {
        $post = Post::with('user')->findOrFail($id);
        $user = auth()->user();

        if ($user->isMainPost($post)) {
            return response()->json(['message' => trans('system.share.self')], Response::HTTP_BAD_REQUEST);
        }

        if ($user->hasSharePost($post)) {
            return response()->json(['message' => trans('system.share.already')], Response::HTTP_OK);
        }

        $share = $post->shares()->updateOrCreate([
            'user_id' => $user->id,
            'description' => $request->description,
        ]);

        Notification::send($post->user, new NewShare($post, $share));
        $post->notifies()->create([
            'user_id' => $user->id,
            'type' => Notify::TYPE_SHARE,
            'text' => trans('notification.blog.share.add'),
        ]);

        $post->timelines()->updateOrCreate([
            'user_id' => $user->id,
            'type' => Timeline::TYPE_SHARE,
            'description' => $request->description,
        ]);

        return response()
            ->json(['message' => trans('system.share.success')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/posts/{id}/complaint 15. Пожаловаться на пост
     * @apiVersion 1.0.0
     * @apiName ComplaintPost
     * @apiGroup 06.Блог
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     * @apiParam {String} complaint_text Текст жалобы
     * @apiParam {String} theme Тема жалобы
     *
     * * @apiDescription Жалобу можно писать не чаще чем через 24 часа
     */
    public function complaint($id, PostComplaintRequest $request)
    {
        $post = Post::with('user')->findOrFail($id);
        $user = auth()->user();
        $admin = User::where('role', User::ROLE_ADMIN)->first();

        if ($user->hasComplaintPost($post)) {
            return response()->json(['message' => trans('system.complaint.already')], Response::HTTP_BAD_REQUEST);
        }

        $complaint = $post->complaints()->create([
            'user_id' => $user->id,
            'complaint_text' => $request->complaint_text,
            'theme' => $request->theme,
        ]);

        Notification::send($admin, new PostComplaint($post, $complaint));

        return response()
            ->json(['message' => trans('system.complaint.success')], Response::HTTP_CREATED);
    }
}
