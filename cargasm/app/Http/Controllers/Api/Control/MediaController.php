<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\Models\Media;

class MediaController extends Controller
{
    /**
     * @api {delete} /api/v1/control/medias/{id} 3. Удаление медиафайлов (админка)
     * @apiVersion 1.0.0
     * @apiName ControlMediaDelete
     * @apiGroup 90.Медиафайлы
     *
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function destroy($id): void
    {
        $this->authorize('media-manage');

        $media = Media::findOrFail($id);
        $media->delete();
    }
}
