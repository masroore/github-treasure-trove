<?php

namespace App\Http\Controllers\Front;

use App\Events\Form\Created;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\FormsRequest;
use App\Http\Traits\MediaLibraryManageTrait;
use App\Models\Form;
use Illuminate\Support\Facades\Event;
use URL;

class FormController extends Controller
{
    use MediaLibraryManageTrait;

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(FormsRequest $request)
    {
        if ($request->type == 'subscribers' && Form::byType('subscribers')->where('data->email', $request->get('email', ''))->first()) {
            $destination = $request->session()->pull('destination', URL::previous());
            if ($request->ajax()) {
                return response()->json([
                    'action' => 'reset',
                    'status' => 'warning',
                ]);
            }

            return redirect()->to($destination)
                ->with('success', trans('notifications.store.success'));
        }

        $form = Form::create(array_merge($this->getVisitorInfo($request), [
            'type' => $request->get('type'),
            'data' => $request->validated(),
            'locale' => $request->get('locale', app()->getLocale()),
        ]));

        if ($request->has('terms')) {
            $form->terms()->sync(array_values_recursive($request->terms));
        }

        $this->manageMedia($form, $request);

        Event::fire(new Created(Form::find($form->id)));

        $destination = $request->session()->pull('destination', URL::previous());
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Ваша заявка успешно принята и будет обработана!',
                'action' => 'reset',
                'status' => 'success', //warning
                //'action' => 'redirect', //reset
                //'destination' => $destination,
                //'message' => trans('notifications.store.success'),
                //'html' => '<p>example</p>',
            ]);
        }

        return redirect()->to($destination)
            ->with('success', trans('notifications.store.success'));
    }

    /**
     * @param $request
     *
     * @return array
     */
    protected function getVisitorInfo($request)
    {
        return [
            'user_id' => optional($request->user())->id,
            'ip' => $request->ip(),
            'referer' => trim($request->headers->get('referer'), '/'),
            'url' => trim($request->fullUrl(), '/'),
        ];
    }
}
