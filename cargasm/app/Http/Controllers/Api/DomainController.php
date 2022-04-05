<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DomainResource;
use App\Models\Domain;

class DomainController extends Controller
{
//     * @api {get} /api/v1/domains 1. Получение списка доменов
//     * @apiVersion 1.0.0
//     * @apiName DomainIndex
//     * @apiGroup 01.Домен
//     *
//     * @apiDescription Получение списка зарегистрированных доменов в системе с языками которые на нем поддерживаются
//     * <br><br> В <code>HEADERS</code> КАЖДОГО ЗАПРОСА ПРИСЫЛАТЬ ЗНАЧЕНИЕ <code>client</code> ЧТО РОВНО URL ДОМЕНА БЕЗ ПРОТОКОЛА!!!
//     * <br> Также нужно передавать значение локали в <code>HEADERS</code>. Пример <code>language = uk</code>
//     */
//    public function index()
//    {
//        $domains = Domain::with('languages')->get();
//
//        return DomainResource::collection($domains);
//    }
}
