<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPushNotificationRequest;
use App\Http\Requests\StorePushNotificationRequest;
use App\Http\Requests\UpdatePushNotificationRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class PushNotificationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('push_notification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pushNotifications.index');
    }

    public function create()
    {
        abort_if(Gate::denies('push_notification_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pushNotifications.create');
    }

    public function store(StorePushNotificationRequest $request)
    {
        $pushNotification = PushNotification::create($request->all());

        return redirect()->route('admin.push-notifications.index');
    }

    public function edit(PushNotification $pushNotification)
    {
        abort_if(Gate::denies('push_notification_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pushNotifications.edit', compact('pushNotification'));
    }

    public function update(UpdatePushNotificationRequest $request, PushNotification $pushNotification)
    {
        $pushNotification->update($request->all());

        return redirect()->route('admin.push-notifications.index');
    }

    public function show(PushNotification $pushNotification)
    {
        abort_if(Gate::denies('push_notification_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pushNotifications.show', compact('pushNotification'));
    }

    public function destroy(PushNotification $pushNotification)
    {
        abort_if(Gate::denies('push_notification_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pushNotification->delete();

        return back();
    }

    public function massDestroy(MassDestroyPushNotificationRequest $request)
    {
        PushNotification::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
