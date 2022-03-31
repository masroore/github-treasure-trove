<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyContactUsMessageRequest;
use App\Http\Requests\StoreContactUsMessageRequest;
use App\Http\Requests\UpdateContactUsMessageRequest;
use App\Models\ContactUsMessage;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class ContactUsMessagesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('contact_us_message_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contactUsMessages = ContactUsMessage::all();

        return view('admin.contactUsMessages.index', compact('contactUsMessages'));
    }

    public function create()
    {
        abort_if(Gate::denies('contact_us_message_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contactUsMessages.create');
    }

    public function store(StoreContactUsMessageRequest $request)
    {
        $contactUsMessage = ContactUsMessage::create($request->all());

        return redirect()->route('admin.contact-us-messages.index');
    }

    public function edit(ContactUsMessage $contactUsMessage)
    {
        abort_if(Gate::denies('contact_us_message_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contactUsMessages.edit', compact('contactUsMessage'));
    }

    public function update(UpdateContactUsMessageRequest $request, ContactUsMessage $contactUsMessage)
    {
        $contactUsMessage->update($request->all());

        return redirect()->route('admin.contact-us-messages.index');
    }

    public function show(ContactUsMessage $contactUsMessage)
    {
        abort_if(Gate::denies('contact_us_message_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contactUsMessages.show', compact('contactUsMessage'));
    }

    public function destroy(ContactUsMessage $contactUsMessage)
    {
        abort_if(Gate::denies('contact_us_message_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contactUsMessage->delete();

        return back();
    }

    public function massDestroy(MassDestroyContactUsMessageRequest $request)
    {
        ContactUsMessage::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
