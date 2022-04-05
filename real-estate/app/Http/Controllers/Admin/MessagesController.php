<?php

namespace App\Http\Controllers\Admin;

use AfricasTalking\SDK\AfricasTalking;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMessageRequest;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\Message;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MessagesController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('message_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $messages = Message::all();

        return view('admin.messages.index', compact('messages'));
    }

    public function create()
    {
        // abort_if(Gate::denies('message_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.messages.create');
    }

    public function store(StoreMessageRequest $request)
    {
        $message = Message::create($request->all());
        //
        // send to farmer
        $username = ''; // use 'sandbox' for development in the test environment
        $apiKey = ''; // use your sandbox app API key for development in the test environment
        $AT = new AfricasTalking($username, $apiKey);

        // Get one of the services
        $sms = $AT->sms();

        // Use the service
        $results = $sms->send([
            'to' => '+' . $request->phone_number,
            'message' => 'Hello, ' . $request->full_name . ' ' . $request->message,
        ]);

        //  print_r(json_encode($results));
        return redirect()->route('admin.messages.index')->with('success', 'Message sent successfully');
    }

    public function edit(Message $message)
    {
        abort_if(Gate::denies('message_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.messages.edit', compact('message'));
    }

    public function update(UpdateMessageRequest $request, Message $message)
    {
        $message->update($request->all());

        return redirect()->route('admin.messages.index');
    }

    public function show(Message $message)
    {
        abort_if(Gate::denies('message_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.messages.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        abort_if(Gate::denies('message_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $message->delete();

        return back();
    }

    public function massDestroy(MassDestroyMessageRequest $request)
    {
        Message::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
