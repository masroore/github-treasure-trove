<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MainResource;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * @api {get} /api/v1/main/{id} 2. Моя страница
     * @apiVersion 1.0.0
     * @apiName HomePage
     * @apiGroup 1.Моя страница
     *
     * @apiDescription Получение сущностей пользователя, в т.ч. чем поделился пользователь
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function index(Request $request, $id)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        $entities = Timeline::where('user_id', $user->id)
            ->with('timelines.media')
            ->orderByDesc('created_at')
            ->paginate($request->per_page);

        return MainResource::collection($entities);
    }
}
