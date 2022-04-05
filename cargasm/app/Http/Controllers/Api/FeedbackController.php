<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckValidLangForDomain;
use App\Http\Requests\FeedbackRequest;
use App\Http\Resources\FeedbackProblemsResource;
use App\Models\Feedback;
use App\Models\FeedbackProblem;
use Illuminate\Http\Response;

class FeedbackController extends Controller
{
    /**
     * @api {get} /api/v1/feedbacks/problems 1. Получение проблем (для подстановки в селект)
     * @apiVersion 1.0.0
     * @apiName FeedbackProblem
     * @apiGroup 05.Контроль качества
     *
     * @apiParam {String} lang Код языка
     */
    public function getProblems(CheckValidLangForDomain $request)
    {
        $problems = FeedbackProblem::where('lang', $request->lang)->orderBy('weight', 'desc')->orderBy('created_at', 'desc')->get();

        return FeedbackProblemsResource::collection($problems);
    }

    /**
     * @api {post} /api/v1/feedbacks 2. Одправка формы контроля качества
     * @apiVersion 1.0.0
     * @apiName FeedbackStore
     * @apiGroup 05.Контроль качества
     *
     * @apiParam {String} fio ФИО пользователя
     * @apiParam {String} phone Телефон пользователя
     * @apiParam {String} problem Проблема
     * @apiParam {String} [descr] Описание проблемы
     * @apiParam {Array} [photos] Масив изображений к проблеме
     */
    public function store(FeedbackRequest $request)
    {
        /** @var Feedback $feedback */
        $feedback = Feedback::create(array_merge($request->validated(), [
            'descr' => $request->descr,
            'status' => Feedback::FEEDBACK_NEW,
            //            'domain' => $request->header('client')
        ]));

        if ($request->photos) {
            foreach ($request->photos as $photo) {
                $feedback->addMedia($photo)->toMediaCollection();
            }
        }

        return response()->json(['message' => trans('system.feedback.store.success')], Response::HTTP_OK);
    }
}
