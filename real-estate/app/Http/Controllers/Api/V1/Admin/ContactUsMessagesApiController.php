<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactUsMessageRequest;
use App\Http\Requests\UpdateContactUsMessageRequest;
use App\Http\Resources\Admin\ContactUsMessageResource;
use App\Models\ContactUsMessage;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class ContactUsMessagesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('contact_us_message_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContactUsMessageResource(ContactUsMessage::all());
    }

    public function store(StoreContactUsMessageRequest $request)
    {
        $contactUsMessage = ContactUsMessage::create($request->all());

        return (new ContactUsMessageResource($contactUsMessage))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ContactUsMessage $contactUsMessage)
    {
        abort_if(Gate::denies('contact_us_message_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContactUsMessageResource($contactUsMessage);
    }

    public function update(UpdateContactUsMessageRequest $request, ContactUsMessage $contactUsMessage)
    {
        $contactUsMessage->update($request->all());

        return (new ContactUsMessageResource($contactUsMessage))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ContactUsMessage $contactUsMessage)
    {
        abort_if(Gate::denies('contact_us_message_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contactUsMessage->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
