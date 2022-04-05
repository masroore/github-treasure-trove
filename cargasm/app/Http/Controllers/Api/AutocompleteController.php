<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use SxGeo;

class AutocompleteController extends Controller
{
    /**
     * @api {get} /api/v1/autocomplete/brands 1. Марки авто (бренды)
     * @apiVersion 1.0.0
     * @apiName GetAutocompleteCarBrands
     * @apiGroup 91.Автозаполнение
     *
     * @apiParam {String} [q] Поисковый запрос
     * @apiParam {Integer} limit=10 Лимит на получение
     */
    public function carBrands(Request $request)
    {
        $limit = $request->get('limit', 10);
        $q = $request->get('q');

        $cars = CarModel::whereIsRoot()->when($q, function ($query) use ($q): void {
            $query->where('name', 'LIKE', '%' . $q . '%');
        })->where('status', true)->take($limit)->get();

        return response()->json(['data' => $cars]);
    }

    /**
     * @api {get} /api/v1/autocomplete/models 2. Модели авто
     * @apiVersion 1.0.0
     * @apiName GetAutocompleteCarModels
     * @apiGroup 91.Автозаполнение
     *
     * @apiParam {String} [q] Поисковый запрос
     * @apiParam {Integer} limit=10 Лимит на получение
     * @apiParam {Int} parent_id Id марки машины (бренд)
     */
    public function carModels(Request $request)
    {
        $this->validate($request, ['parent_id' => 'required']);

        $limit = $request->get('limit', 10);
        $q = $request->get('q');

        $cars = CarModel::where('level', 2)
            ->where('parent_id', $request->parent_id)
            ->when($q, function ($query) use ($q): void {
                $query->where('name', 'LIKE', '%' . $q . '%');
            })->where('status', true)->take($limit)->get();

        return response()->json(['data' => $cars]);
    }

    /**
     * @api {get} /api/v1/autocomplete/users 3. Пользователи
     * @apiVersion 1.0.0
     * @apiName GetAutocompleteUsers
     * @apiGroup 91.Автозаполнение
     *
     * @apiParam {String} [q] Поисковый запрос
     * @apiParam {Integer} limit=10 Лимит на получение
     * @apiParam {Array|String=partner,user} [roles[]] Роли пользователя
     */
    public function users(Request $request)
    {
        $limit = $request->get('limit', 10);
        $q = $request->get('q');

        $roles = $request->roles ? (array) $request->roles : false;

        $users = User::when($roles, function ($q) use ($roles): void {
            $q->whereIn('role', $roles);
        })->when($q, function ($query) use ($q): void {
            $query->where(function ($query) use ($q): void {
                $query->where('name', 'LIKE', '%' . $q . '%')
                    ->orWhere('surname', 'LIKE', '%' . $q . '%')
                    ->orWhere('nickname', 'LIKE', '%' . $q . '%');
            });
        })->select('id', 'name', 'surname', 'nickname')
            //->where('role', '<>', 'admin')
            ->take($limit)->get();

        return response()->json(['data' => $users]);
    }

    /**
     * @api {get} /api/v1/autocomplete/services 4. СТО
     * @apiVersion 1.0.0
     * @apiName GetAutocompleteServices
     * @apiGroup 91.Автозаполнение
     *
     * @apiParam {String} [q] Поисковый запрос
     * @apiParam {Integer} limit=10 Лимит на получение
     * @apiParam {Integer} [user_id] Партрер, создавший сто
     */
    public function services(Request $request)
    {
        $limit = $request->get('limit', 10);
        $q = $request->get('q');
        $userId = $request->user_id;

        $items = Service::byLangs()->when($q, function ($query) use ($q): void {
            $query->where(function ($query) use ($q): void {
                $query->where('name', 'LIKE', '%' . $q . '%')
                    ->orWhere('email', 'LIKE', '%' . $q . '%')
                    ->orWhere('place', 'LIKE', '%' . $q . '%')
                    ->orWhere('street', 'LIKE', '%' . $q . '%');
            });
        })->when($userId, function ($q) use ($userId): void {
            $q->where('user_id', $userId);
        })->select('id', 'name', 'email', 'place', 'user_id')
            ->take($limit)->get();

        return response()->json(['data' => $items]);
    }

    /**
     * @api {get} /api/v1/autocomplete/geo 5. Мои координаты
     * @apiVersion 1.0.0
     * @apiName GetAutocompleteGeo
     * @apiGroup 91.Автозаполнение
     */
    public function geo(Request $request)
    {
        $ip = $request->get('ip', $request->getClientIp());
        $geo = SxGeo::get($ip);

        return [
            'data' => [
                'lat' => $geo['city']['lat'] ?? '',
                'lng' => $geo['city']['lon'] ?? '',
            ],
        ];
    }
}
