<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckValidLangForDomain;
use App\Http\Requests\CommentAddRequest;
use App\Http\Requests\PhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PhotoResource;
use App\Models\Comment;
use App\Models\Notify;
use App\Models\Photo;
use App\Models\Timeline;
use App\Models\User;
use App\Notifications\Photo\NewShare;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @api {get} /api/v1/gallery/photos 1. Получение всех фотографий
     * @apiVersion 1.0.0
     * @apiName GalleryPhotoIndex
     * @apiGroup 07.Фотографии
     *
     * @apiDescription Получение всех фотографий
     *
     * @apiParam {String} lang Код языка
     * @apiParam {String} [sort] Сортировка постов доступные значение <code>date, comment, like</code>
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function index(CheckValidLangForDomain $request)
    {
        $user = $request->user();

        $photos = Photo::with('media', 'user')->withCount('likes', 'comments')->whereHas('user', function ($query): void {
        })
            ->where('lang', $request->lang)
            ->where('user_id', $user->id)
//            ->filter($request->sort)
            ->orderBy('weight')
            ->paginate($request->per_page);

        return PhotoResource::collection($photos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CheckValidLangForDomain $request)
    {
    }

    /**
     * @api {post} /api/v1/gallery/photos 2. Добавление фото
     * @apiVersion 1.0.0
     * @apiName GalleryPhotoStore
     * @apiGroup 07.Фотографии
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} lang Аббревиатура языка на котором создается пост
     * @apiParam {File} photo Фото
     * @apiParam {String} title Заголовок
     */
    public function store(PhotoRequest $request, $uuid = false)
    {
        $user = $request->user();

        if ($user->role === User::ROLE_PARTNER || $user->role === User::ROLE_ADMIN) {
            foreach ($request->photos as $item) {
                $photo = Photo::create([
                    'title' => $item['title'],
                    'lang' => $request->lang,
                    'user_id' => $user->id,
                    //                    'weight' => $item['photo']['weight'],
                ]);

                if ($item['photo']['file']) {
                    $photo->addMedia($item['photo']['file'])->toMediaCollection('images');
                }
            }
        } else {
            foreach ($request->photos as $item) {
                $photo = $user->photos()->create([
                    'title' => $item['title'],
                    'lang' => $request->lang,
                    'user_id' => $user->id,
                    //                    'weight' => $item['photo']['weight'],
                ]);

                if ($item['photo']['file']) {
                    $photo->addMedia($item['photo']['file'])->toMediaCollection('images');
                }
            }
        }
        $photo->timelines()->updateOrCreate([
            'user_id' => $user->id,
            'type' => Timeline::TYPE_ADD,
        ]);

        return response()
            ->json(['message' => trans('system.store.success')], Response::HTTP_ACCEPTED);
    }

    /**
     * @api {get} /api/v1/gallery/photos/{id} 2. Получение фото
     * @apiVersion 1.0.0
     * @apiName GalleryPhotoShow
     * @apiGroup 07.Фотографии
     *
     * @apiDescription Получение отдельной фотографии
     */
    public function show($id)
    {
        $photo = Photo::with('media', 'user')->withCount('likes', 'comments')->findOrFail($id);

        return PhotoResource::make($photo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        return response()->json([
            'photo' => PhotoResource::collection(Photo::find($photo)),
        ]);
    }

    /**
     * @api {put/patch} /api/v1/photos/{id} 6. Обновление фотографии
     * @apiVersion 1.0.0
     * @apiName PhotoUpdate
     * @apiGroup 07.Фотографии
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {File} [photo] Фото
     * @apiParam {String} title Заголовок
     */
    public function update(UpdatePhotoRequest $request, $id)
    {
        $user = auth()->user();
        $photo = Photo::with('media')->findOrFail($id);

        if (Gate::allows('update-photo', $photo)) {
            //    if ($user->role === User::ROLE_PARTNER || $user->role === User::ROLE_ADMIN) {
            $photo->update([
                'title' => $request->title,
            ]);
            //    }

            if ($request->hasFile('photo.file')) {
                $photo->clearMediaCollection('images');
                $photo->addMediaFromRequest('photo.file')->toMediaCollection('images');
            }

            if (!$request->photo) {
                $photo->clearMediaCollection('images');
            }

            $photo->timelines()->update([
                'user_id' => $user->id,
                'type' => Timeline::TYPE_UPDATE,
            ]);

            return response()
                ->json(['message' => trans('system.update.success'), 'photo' => PhotoResource::make($photo)], Response::HTTP_ACCEPTED);
        }

        return response()->json(['message' => trans('system.destroy.error')], Response::HTTP_FORBIDDEN);
    }

    /**
     * @api {delete} /api/v1/gallery/photos/{id} 7. Удаление фото
     * @apiVersion 1.0.0
     * @apiName PhotoDelete
     * @apiGroup 07.Фотографии
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function destroy(int $id)
    {
        $photo = Photo::with('media')->findOrFail($id);

        if (Gate::allows('delete-photo', $photo)) {
            $photo->clearMediaCollection('images');
            Storage::delete($photo->photo);
            $photo->comments()->delete();
            $photo->likes()->delete();
            $photo->timelines()->delete();
            $photo->delete();

            return response()
                ->json(['message' => trans('system.destroy.success')], Response::HTTP_OK);
        }

        return response()->json(['message' => trans('system.destroy.error')], Response::HTTP_FORBIDDEN);
    }

    /**
     * @api {post} /api/v1/gallery/photos/{id}/like 10. Лайкнуть фото
     * @apiVersion 1.0.0
     * @apiName LikeAdd
     * @apiGroup 07.Фотографии
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function getLike($id)
    {
        $photo = Photo::find($id);
        $user = auth()->user();

        if (!$photo) {
            return response()
                ->json(['message' => trans('system.like.save')], Response::HTTP_NOT_FOUND);
        }

        if ($user->hasLikedPhoto($photo)) {
            $photo->likes()->delete();

            return response()
                ->json(['message' => trans('system.like.delete')], Response::HTTP_OK);
        }

        $photo->likes()->create(['user_id' => $user->id]);

        return response()
            ->json(['message' => trans('system.like.save')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/gallery/photos/{id}/comment 11. Добавить коментарий к фотографии
     * @apiVersion 1.0.0
     * @apiName CommentAdd
     * @apiGroup 07.Фотографии
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} text Текст коментария
     */
    public function comment($id, CommentAddRequest $request)
    {
        $photo = Photo::findOrFail($id);
        $user = $request->user();

//          if (!$photo->allowComment()) {
//             return response()->json(['message' => trans('system.comment.permission')], Response::HTTP_BAD_REQUEST);
//         }

        $comment = $photo->comments()->create([
            'user_id' => $user->id,
            'text' => $request->text,
        ]);

        return response()->json(['message' => trans('system.comment.save'), 'comment' => CommentResource::make($comment)], Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/gallery/photos/{id}/comment 3. Получение коментариев к фотографии
     * @apiVersion 1.0.0
     * @apiName getPhotoComment
     * @apiGroup 07.Фотографии
     */
    public function getPhotoComments($id)
    {
        $photo = Photo::findOrFail($id);
        $comments = Comment::getChildTreeArray($photo->comments()->with('user', 'parent')->withCount('likes')->orderBy('created_at')->get());

        return CommentResource::collection($comments);
    }

    /**
     * @api {get} /api/v1/users/{id}/photos 8. Получение всех фотографий  юзера
     * @apiVersion 1.0.0
     * @apiName PhotoUsers
     * @apiGroup 07.Фотографии
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function getUserPhotos($id, Request $request)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        $photos = Photo::with('media', 'user')->withCount('likes', 'comments')->whereHas('user', function ($query): void {
        })
            ->where('lang', $request->lang)
            ->where('user_id', $user->id)
            ->filter($request->sort)
            ->paginate($request->per_page);

        return PhotoResource::collection($photos);
    }

    /**
     * @api {post} /api/v1/gallery/photos/{id}/share 12. Поделиться фотографией
     * @apiVersion 1.0.0
     * @apiName SharePhoto
     * @apiGroup 07.Фотографии
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function share($id, Request $request)
    {
        $photo = Photo::with('user')->findOrFail($id);
        $user = auth()->user();

        if ($user->isMainPhoto($photo)) {
            return response()->json(['message' => trans('system.share.self')], Response::HTTP_BAD_REQUEST);
        }

        if ($user->hasSharePhoto($photo)) {
            return response()->json(['message' => trans('system.photo.share.already')], Response::HTTP_OK);
        }

        $share = $photo->shares()->create([
            'user_id' => $user->id,
            'description' => $request->description,
        ]);

        Notification::send($photo->user, new NewShare($photo, $share));
        $photo->notifies()->create([
            'user_id' => $user->id,
            'type' => Notify::TYPE_SHARE,
            'text' => trans('notification.photo.share.add'),
        ]);

        $photo->timelines()->updateOrCreate([
            'user_id' => $user->id,
            'type' => Timeline::TYPE_SHARE,
            'description' => $request->description,
        ]);

        return response()
            ->json(['message' => trans('system.photo.share.success')], Response::HTTP_OK);
    }
}
