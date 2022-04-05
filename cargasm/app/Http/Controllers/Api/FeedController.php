<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckValidLangForDomain;
use App\Http\Resources\EventLineResource;
use App\Http\Resources\FavoriteResource;
use App\Http\Resources\MainResource;
use App\Http\Resources\PostLineResource;
use App\Http\Resources\PostResource;
use App\Models\Favorite;
use App\Models\Post;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * @api {get} /api/v1/user/all-feed 5. Получить все сущности в ленту
     * @apiVersion 1.0.0
     * @apiName GetAllFeed
     * @apiGroup 14.Лента
     * @apiHeader {String} Authorization  Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function allFeed(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $entities = [];

        $subscriptions = $user->subscriptions->mapToGroups(function ($item, $key) {
            return [$item['subscription_type'] => $item['subscription_id']];
        })->toArray();

        if ($subscriptions) {
            $entities = Timeline::where(function ($query) use ($subscriptions): void {
                foreach ($subscriptions as $ids) {
                    $query->OrWhere(function ($query) use ($ids): void {
                        $query->whereIn('user_id', $ids);
                    });
                }
            })->with('timelines')
                ->orderByDesc('created_at')
                ->paginate($request->per_page);

            return MainResource::collection($entities);
        }

        return PostLineResource::collection($entities);
    }

    /**
     * @api {get} /api/v1/user/news-feed 1. Получить статьи с подписки в ленту
     * @apiVersion 1.0.0
     * @apiName GetNewsFeed
     * @apiGroup 14.Лента
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function getNewsFeed(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $posts = [];

        $subscriptions = $user->subscriptions->mapToGroups(function ($item, $key) {
            return [$item['subscription_type'] => $item['subscription_id']];
        })->toArray();

        if ($subscriptions) {
            $posts = Timeline::where('timelines_type', 'App\Models\Post')->where(function ($query) use ($subscriptions): void {
                foreach ($subscriptions as $ids) {
                    $query->OrWhere(function ($query) use ($ids): void {
                        $query->whereIn('user_id', $ids);
                    });
                }
            })->with('timelines')
                ->orderByDesc('created_at')
                ->paginate($request->per_page);

            return PostLineResource::collection($posts);
        }

        return PostLineResource::collection($posts);
    }

    /**
     * @api {get} /api/v1/user/events-feed 4. Получить события с подписки в ленту
     * @apiVersion 1.0.0
     * @apiName GetEventsFeed
     * @apiGroup 14.Лента
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     *
     * @apiDescription Если поле <code>type = 'share'</code>, событием поделились, <code>share_user</code> - кто поделился
     */
    public function getEventsFeed(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $events = [];

        $subscriptions = $user->subscriptions->mapToGroups(function ($item, $key) {
            return [$item['subscription_type'] => $item['subscription_id']];
        })->toArray();

        if ($subscriptions) {
            $events = Timeline::where('timelines_type', 'App\Models\Event')->where(function ($query) use ($subscriptions): void {
                foreach ($subscriptions as $ids) {
                    $query->OrWhere(function ($query) use ($ids): void {
                        $query->whereIn('user_id', $ids);
                    });
                }
            })->with('timelines')
                ->orderByDesc('created_at')
                ->paginate($request->per_page);

            return EventLineResource::collection($events);
        }

        return EventLineResource::collection($events);
    }

    /**
     * @api {get} /api/v1/user/favorites 2. Получить избранные статьи
     * @apiVersion 1.0.0
     * @apiName GetNewsFeedFavorite
     * @apiGroup 14.Лента
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function getFavorites(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $favorites = Favorite::where('user_id', $user->id)
            ->with('favoriteable.media')
            ->orderByDesc('created_at')
            ->paginate($request->per_page);

        return FavoriteResource::collection($favorites);
    }

    /**
     * @api {get} /api/v1/user/recommends 3. Рекомендованые статьи
     * @apiVersion 1.0.0
     * @apiName GetNewsFeedRecommended
     * @apiGroup 14.Лента
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} lang Код языка
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function getRecommendedPosts(CheckValidLangForDomain $request)
    {
        $posts = Post::with('media', 'author')->withCount('likes', 'comments')->where('status', Post::POST_PUBLISHED)
            ->where('lang', $request->lang)
            ->orderByDesc('comments_count')
            ->orderByDesc('likes_count')
            ->paginate($request->per_page);

        return PostResource::collection($posts);
    }
}
