<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Notify;
use App\Models\Service;
use App\Models\User;
use App\Notifications\NewSubcriber;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['subscribe', 'unsubscribe']);
    }

    /**
     * @api {post} /api/v1/subscribe 1. Подписаться на юзера/сервис
     * @apiVersion 1.0.0
     * @apiName SubscriptionAdd
     * @apiGroup 13.Подписки
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} type Тип сущности: <code>['user', 'service']</code>
     * @apiParam {int} id Id сущности
     */
    public function subscribe(SubscriptionRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $subscriptionType = $request->type === 'user' ? 'App\Models\User' : 'App\Models\Service';
        $subscriptionId = $request->id;
        $subscriptionObject = $subscriptionType::find($subscriptionId);

        if (!$subscriptionObject || $request->type === 'user' && $subscriptionId == $user->id) {
            return response()->json(['message' => trans('system.subscription.error')], Response::HTTP_BAD_REQUEST);
        }

        if ($user->checkSubscription($request->type, $subscriptionId)) {
            return response()->json(['message' => trans('system.subscription.already')], Response::HTTP_BAD_REQUEST);
        }

        $subscriber = $user->subscriptions()->create([
            'subscription_type' => $subscriptionType,
            'subscription_id' => $subscriptionId,
        ]);

        if ($subscriptionObject instanceof User) {
            Notification::send($subscriptionObject, new NewSubcriber($subscriber));
            $user->notifies()->create([
                'user_id' => $subscriptionObject->id,
                'type' => Notify::TYPE_SUBSCRIBER,
                'text' => trans('notification.subscription.title'),
            ]);
        }
        if ($subscriptionObject instanceof Service) {
            Notification::send($subscriptionObject->user(), new NewSubcriber($subscriber));
            $user->notifies()->create([
                'user_id' => $subscriptionObject->user->id,
                'type' => Notify::TYPE_SUBSCRIBER,
                'text' => trans('notification.subscription.title'),
            ]);
        }

        return response()->json(['message' => trans('system.subscription.add')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/unsubscribe 2. Отписаться на юзера/сервис
     * @apiVersion 1.0.0
     * @apiName SubscriptionRemove
     * @apiGroup 13.Подписки
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} type Тип сущности: <code>['user', 'service']</code>
     * @apiParam {int} id Id сущности
     */
    public function unsubscribe(SubscriptionRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        if (!$user->checkSubscription($request->type, $request->id)) {
            return response()->json(['message' => trans('system.subscription.denies')], Response::HTTP_NOT_FOUND);
        }

        $notifications = Notify::where([
            'notifiable_type' => $request->type === 'user' ? 'App\Models\User' : 'App\Models\Service',
            'notifiable_id' => $user->id,
            'user_id' => $request->id,
            'type' => Notify::TYPE_SUBSCRIBER,
        ])->delete();

        $user->subscriptions()->where([
            'subscription_type' => $request->type === 'user' ? 'App\Models\User' : 'App\Models\Service',
            'subscription_id' => $request->id,
        ])->delete();

        $user->notifies()->where([
            'notifiable_type' => $request->type === 'user' ? 'App\Models\User' : 'App\Models\Service',
            'notifiable_id' => $request->id,
        ])->delete();

        return response()->json(['message' => trans('system.subscription.unsubscribe')], Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/users/{id}/subscriptions 3. Получить подписки юзера
     * @apiVersion 1.0.0
     * @apiName GetSubscriptionsForUser
     * @apiGroup 13.Подписки
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function getSubscriptions($id)
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        $subscriptions = $user->subscriptions()->hasMorph('subscription', '*')->orderByDesc('created_at')->get();

        $subscriptionsEntity = $subscriptions->map(function ($key, $item) {
            return [
                'id' => $key->subscription->id,
                'name' => $key->subscription->name,
                'surname' => $key->subscription->surname,
                'nickname' => $key->subscription->nickname,
                'main_photo' => $key->subscription->getAllConversions(),
                'type' => ($key->subscription->getTable() === 'users') ? 'user' : 'service',
                'slug' => ($key->subscription->getTable() === 'services') ? $key->subscription->slug : '',
            ];
        });

        return response()->json(['data' => $subscriptionsEntity], Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/users/{id}/subscribers 4. Получить подписчиков юзера
     * @apiVersion 1.0.0
     * @apiName GetSubscribersForUser
     * @apiGroup 13.Подписки
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function getSubscribers($id)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        $subscribers = $user->subscribers()->has('user')->with('user')->orderByDesc('created_at')->get();

        $subscribersEntity = $subscribers->map(function ($key, $item) {
            return [
                'id' => $key->user->id,
                'name' => $key->user->name,
                'surname' => $key->user->surname,
                'nickname' => $key->user->nickname,
                'main_photo' => $key->user->getAllConversions(),
                'type' => 'user',
            ];
        });

        return response()->json(['data' => $subscribersEntity], Response::HTTP_OK);
    }
}
