<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentAddRequest;
use App\Http\Requests\Complaint\PostComplaintRequest;
use App\Http\Requests\RatingRequest;
use App\Http\Requests\RatingUpdateRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\User;
use App\Notifications\Rating\RatingComplaint;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class RatingController extends Controller
{
    /**
     * @api {post} /api/v1/ratings 1. Добавить свою оценку СТО
     * @apiVersion 1.0.0
     * @apiName RatingsAdd
     * @apiGroup 13.Оценка СТО
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {Int} score оценка [0-5]
     * @apiParam {String} text Текст
     * @apiParam {Int} service_id Id СТО
     */
    public function store(RatingRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();
        if ($user->checkFeedbackService($request->service_id)) {
            return response()->json(['message' => trans('system.rating.permission')], Response::HTTP_BAD_REQUEST);
        }

        $rating = $user->ratings()->create($request->validated());

        return response()->json(['message' => trans('system.rating.add'), 'rating' => $rating], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/ratings/{id} 2. Изменить свой отзыв
     * @apiVersion 1.0.0
     * @apiName RatingsUpdate
     * @apiGroup 13.Оценка СТО
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {Int} score оценка [0-5]
     * @apiParam {String} text Текст
     */
    public function update(RatingUpdateRequest $request, $id)
    {
        $user = auth()->user();

        $rating = Rating::findOrFail($id);
        /** @var User $user */
        if (Gate::allows('update-event', $rating)) {
            $rating->update([
                'score' => $request->score,
                'text' => $request->text,
            ]);

            return response()->json(['message' => trans('system.update.success'), 'rating' => $rating], Response::HTTP_OK);
        }

        return response()->json(['message' => trans('system.rating.denies')], Response::HTTP_FORBIDDEN);
    }

    /**
     * @api {post} /api/v1/ratings/{id}/comment 3. Добавить коментарий к отзыву
     * @apiVersion 1.0.0
     * @apiName CommentAdd
     * @apiGroup 13.Оценка СТО
     * @apiParam {String} text Текст коментария
     */
    public function comment($id, CommentAddRequest $request)
    {
        $rating = Rating::findOrFail($id);
        $user = $request->user();

        $comment = $rating->comments()->create([
            'user_id' => $user->id,
            'text' => $request->text,
        ]);

        return response()->json(['message' => trans('system.comment.save'), 'comment' => CommentResource::make($comment)], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/ratings/{id}/like 4. Лайкнуть отзыв
     * @apiVersion 1.0.0
     * @apiName LikeAdd
     * @apiGroup 13.Оценка СТО
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function getLike($id, Request $request)
    {
        $rating = Rating::findOrFail($id);
        $user = $request->user();

        if ($user->hasLikedRating($rating)) {
            $rating->likes()->delete();

            return response()
                ->json(['message' => trans('system.like.delete')], Response::HTTP_OK);
        }

        $like = $rating->likes()->create(['user_id' => $user->id]);

        return response()
            ->json(['message' => trans('system.like.save')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/ratings/{id}/complaint 5. Пожаловаться на отзыв
     * @apiVersion 1.0.0
     * @apiName ComplaintRating
     * @apiGroup 13.Оценка СТО
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     * @apiParam {String} complaint_text Текст жалобы
     * @apiParam {String} theme Тема жалобы
     *
     * * @apiDescription Жалобу можно писать не чаще чем через 24 часа
     */
    public function complaint($id, PostComplaintRequest $request)
    {
        $rating = Rating::findOrFail($id);
        $user = auth()->user();

        if ($user->hasComplaintRating($rating)) {
            return response()->json(['message' => trans('system.complaint.already')], Response::HTTP_BAD_REQUEST);
        }

        $complaint = $rating->complaints()->create([
            'user_id' => $user->id,
            'complaint_text' => $request->complaint_text,
            'theme' => $request->theme,
        ]);

        Notification::send($complaint->user, new RatingComplaint($rating, $complaint));

        return response()
            ->json(['message' => trans('system.complaint.success')], Response::HTTP_CREATED);
    }

    /**
     * @api {delete} /api/v1/ratings/{id} 6. Удалить свой отзыв
     * @apiVersion 1.0.0
     * @apiName RatingsDelete
     * @apiGroup 13.Оценка СТО
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);

        if (Gate::denies('service-delete', $rating)) {
            return response()->json(['message' => trans('system.rating.denies')], Response::HTTP_FORBIDDEN);
        }

        $rating->comments()->delete();
        $rating->complaints()->delete();
        $rating->likes()->delete();

        $rating->delete();

        return response()->json(['message' => trans('system.rating.delete')], Response::HTTP_OK);
    }
}
