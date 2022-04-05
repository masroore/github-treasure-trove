<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Car;
use App\Models\Event;
use App\Models\Message;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\Models\Media;

class MediaController extends Controller
{
    /**
     * @api {post} /api/v1/medias 1. Загрузить фото на сервер
     * @apiVersion 1.0.0
     * @apiName savePhoto
     * @apiGroup 90.Медиафайлы
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        if (is_file($request->file('upload'))) {
            $media = $user->addMedia($request->file('upload'))->toMediaCollection('post_photo');

            return response()->json([
                'url' => $media->getFullUrl(),
                'fileName' => $media->file_name,
                'uploaded' => 1,
            ]);
        }
    }

    /**
     * @api {delete} /api/v1/medias/{id} 2. Удаление медиафайлов
     * @apiVersion 1.0.0
     * @apiName BlogIndex
     * @apiGroup 90.Медиафайлы
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $media = Media::findOrFail($id);
        $deleteFlag = false;

        if ($media->model instanceof Car) {
            if ($media->model->user->id === $user->id) {
                $media->delete();
                $deleteFlag = true;
            }
        }

        if ($media->model instanceof Message && $media->collection_name == 'docs') {
            if ($media->model->senderData->id === $user->id) {
                $media->delete();
                $deleteFlag = true;
            }
        }

        if ($media->model instanceof Service) {
            if ($media->model->user->id === $user->id) {
                $media->delete();
                $deleteFlag = true;
            }
        }
        if ($media->model instanceof Post) {
            if ($media->model->user->id === $user->id) {
                $media->delete();
                $deleteFlag = true;
            }
        }

        if ($media->model instanceof Event) {
//            if ($media->collection_name == 'images')
//            {
            if ($media->model->user->id === $user->id) {
                $media->delete();
                $deleteFlag = true;
            }
//            }
        }

        if ($media->model instanceof Album) {
            if ($media->model->user->id === $user->id) {
                $media->delete();
                $deleteFlag = true;
            }
        }

        return response()->json(['message' => $deleteFlag ? trans('system.media.delete') : trans('system.media.error')], $deleteFlag ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
