<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePushNotificationRequest;
use App\Http\Requests\UpdatePushNotificationRequest;
use App\Http\Resources\Admin\PushNotificationResource;
use App\Models\PushNotification;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class PushNotificationApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('push_notification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PushNotificationResource(PushNotification::all());
    }

    public function store(StorePushNotificationRequest $request)
    {
        $pushNotification = PushNotification::create($request->all());

        return (new PushNotificationResource($pushNotification))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PushNotification $pushNotification)
    {
        abort_if(Gate::denies('push_notification_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PushNotificationResource($pushNotification);
    }

    public function update(UpdatePushNotificationRequest $request, PushNotification $pushNotification)
    {
        $pushNotification->update($request->all());

        return (new PushNotificationResource($pushNotification))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PushNotification $pushNotification)
    {
        abort_if(Gate::denies('push_notification_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pushNotification->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
