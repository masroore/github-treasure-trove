<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Http\Resources\Control\ComplaintResource;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComplaintController extends Controller
{
    /**
     * @api {get} /api/v1/control/complaints 1. Ошибки и жалобы
     * @apiVersion 1.0.0
     * @apiName Complaints
     * @apiGroup 41. Жалобы
     *
     * @apiDescription Получение всех ошибок и жалоб
     *
     * @apiParam {int} [page=1] Номер страницы
     * @apiParam {int} [per_page=15] Количество элементов для вывода
     */
    public function index(Request $request)
    {
        $complaints = Complaint::with('user')
            ->orderByDesc('created_at')
            ->paginate($request->per_page);

        return ComplaintResource::collection($complaints);
    }

    /**
     * @api {get} /api/v1/control/complaints/{id} 2. Получение отдельной жалобы
     * @apiVersion 1.0.0
     * @apiName ComplaintShow
     * @apiGroup 41. Жалобы
     *
     * @apiDescription Получение жалобы
     */
    public function show($id)
    {
        $complaint = Complaint::with('user')->findOrFail($id);

        return ComplaintResource::make($complaint);
    }

    /**
     * @api {delete} /api/v1/control/complaints/{id} 7. Удаление жалобы
     * @apiVersion 1.0.0
     * @apiName ComplaintsDestroy
     * @apiGroup 41. Жалобы
     */
    public function destroy($id)
    {
        $complaint = Complaint::with('user')->findOrFail($id);
        $complaint->delete();

        return response()
            ->json(['message' => trans('system.destroy.success')], Response::HTTP_OK);
    }
}
