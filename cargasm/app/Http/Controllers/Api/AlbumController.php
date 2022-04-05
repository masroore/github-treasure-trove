<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlbumRequest;
use App\Http\Requests\AlbumUpdateRequest;
use App\Http\Requests\CheckValidLangForDomain;
use App\Http\Resources\AlbumResource;
use App\Models\Album;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    /**
     * @api {get} /api/v1/gallery/albums 1. Все альбомы
     * @apiVersion 1.0.0
     * @apiName GalleryAlbumsIndex
     * @apiGroup 12.Альбомы
     *
     * @apiDescription Получение всех альбомов
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
        $albums = Album::with('media', 'photos', 'user')->whereHas('user', function ($query): void {
        })
            ->where('lang', $request->lang)
            ->where('user_id', $user->id)
            ->filter($request->sort)
            ->paginate($request->per_page);

        return AlbumResource::collection($albums);
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
     * @api {post} /api/v1/gallery/albums 1. Добавить альбом
     * @apiVersion 1.0.0
     * @apiName AlbumStore
     * @apiGroup 12.Альбомы
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} lang Аббревиатура языка на котором создается пост
     * @apiParam {File} main_photo Главное фото
     * @apiParam {File} photos Фотографии в альбоме
     * @apiParam {String} title Заголовок
     * @apiParam {String} descr Описание альбома
     */
    public function store(AlbumRequest $request, $uuid = false)
    {
        $user = auth()->user();

        if ($user->role === User::ROLE_PARTNER || $user->role === User::ROLE_ADMIN) {
            $album = Album::create(array_merge(
                Arr::except($request->validated(), ['main_photo', 'photos']),
                [
                    'uuid' => $uuid ? $uuid : Str::uuid()->toString(),
                    'lang' => $request->lang,
                    'user_id' => $user->id,
                    'title' => $request->title,
                ]
            ));
        } else {
            /** @var Photo $photo */
            $album = $user->albums()->create(array_merge(
                Arr::except($request->validated(), ['main_photo', 'photos']),
                [
                    'uuid' => $uuid ? $uuid : Str::uuid()->toString(),
                    'lang' => $request->lang,
                    'user_id' => $user->id,
                    'title' => $request->title,
                ]
            ));
        }

        if ($request->hasFile('main_photo.file')) {
            $album->addMedia($request->main_photo['file'])->toMediaCollection('image');
        }

        if ($request->photos) {
            foreach ($request->photos as $file) {
                $photo = Photo::create([
                    'title' => $request->title,
                    'lang' => $request->lang,
                    'user_id' => $user->id,
                    'album_id' => $album->id,
                    'weight' => $file['weight'],
                ]);
                $photo->mediaSave([
                    'file' => $file['file'],
                ], 'images');
            }
        }

        return response()
            ->json(['message' => trans('system.update.success'), 'album' => $album], Response::HTTP_ACCEPTED);
    }

    /**
     * @api {get} /api/v1/gallery/albums/{id} 2. Получение альбома
     * @apiVersion 1.0.0
     * @apiName GalleryAlbumShow
     * @apiGroup 12.Альбомы
     *
     * @apiDescription Получение отдельного альбома
     */
    public function show($id)
    {
        $album = Album::with('media', 'photos')->findOrFail($id);

        return AlbumResource::make($album);
    }

    public function edit(Album $album)
    {
        return response()->json([
            'album' => AlbumResource::collection(Album::find($album)),
        ]);
    }

    /**
     * @api {put/patch} /api/v1/gallery/albums/{id} 6. Обновление альбома
     * @apiVersion 1.0.0
     * @apiName AlbumUpdate
     * @apiGroup 12.Альбомы
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} lang Аббревиатура языка на котором создается пост
     * @apiParam {File} main_photo Главное фото
     * @apiParam {File} photos Фотографии в альбоме
     * @apiParam {String} title Заголовок
     * @apiParam {String} descr Описание альбома
     */
    public function update(AlbumUpdateRequest $request, $id)
    {
        $album = Album::with('media', 'user')->findOrFail($id);

        if (Gate::allows('update-album', $album)) {
            //    if ($user->role === User::ROLE_PARTNER || $user->role === User::ROLE_ADMIN) {
            $album->update([
                'descr' => $request->descr,
                'title' => $request->title,
            ]);
            //    }

            if ($request->hasFile('main_photo.file')) {
                $album->clearMediaCollection('image');
                $album->addMediaFromRequest('main_photo.file')->toMediaCollection('image');
            }

            if ($request->photos) {
//           if($request->hasFile('photos.*.file')) {
                $i = 0;
                foreach ($request->photos as $file) {
                    if (isset($file['file'])) {
                        $photo = Photo::create([
                            'title' => $request->title,
                            'lang' => $request->lang,
                            'user_id' => $album->user->id,
                            'album_id' => $album->id,
                            'weight' => $i,
                        ]);
                        $photo->mediaSave([
                            'file' => $file['file'],
                        ], 'images');
                    } else {
                        if ($photo = Photo::find($file['id'])) {
                            $photo->update(['weight' => $i]);
                        }
                    }

                    ++$i;
                }
            }

            if (!$request->main_photo) {
                $album->clearMediaCollection('image');
            }

            return response()
                ->json(['message' => trans('system.update.success')], Response::HTTP_ACCEPTED);
        }
    }

    /**
     * @api {delete} /api/v1/gallery/albums/{id} 7. Удаление альбома
     * @apiVersion 1.0.0
     * @apiName AlbumDelete
     * @apiGroup 12.Альбомы
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function destroy($id)
    {
        $album = Album::with('media', 'photos')->findOrFail($id);
        $photos = Photo::with('media')->where('album_id', $album->id)->get();

        if (Gate::allows('delete-album', $album)) {
            $album->clearMediaCollection('main_photo');
            foreach ($photos as $photo) {
                $photo->clearMediaCollection('images');
                Storage::delete($photo->photo);
            }
            Storage::delete($album->main_photo);
            $album->delete();

            return response()
                ->json(['message' => trans('system.destroy.success')], Response::HTTP_OK);
        }
    }

    /**
     * @api {get} /api/v1/users/{id}/albums 8. Получение альбомов юзера
     * @apiVersion 1.0.0
     * @apiName AlbumsUsers
     * @apiGroup 12.Альбомы
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function getUserAlbums($id, Request $request)
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        $albums = Album::with('media', 'photos')
            ->where('user_id', $user->id)
            ->paginate($request->per_page);

        return AlbumResource::collection($albums);
    }
}
