<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Auth\Middleware\Auth;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class MessageController extends Controller
{
    /**
     * Restricting certain functions to Auth Users only.
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['index', 'destroy', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::get();

        return view('messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new message.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assignedCats = [];

        return view('messages.create', compact('assignedCats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'email' => 'email|required',
            'name' => 'required|min:5',
            'subject' => 'required|min:5',
            'content' => 'required|min:10',
        ]);

        $message = new Message();

        $message->name = $request->name;
        $message->email = $request->email;
        $message->subject = $request->subject;
        $message->content = Purifier::clean($request->content);

        if (strtoupper($request->my_question) === 'DUTCH') {
            $message->save();

            return redirect('/')->with('success', 'Message has been sent');
        }

        return redirect('/')->with('failure', 'No Message has been sent');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        $message = Message::find($message->id);

        return view('messages.show', compact('message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message = Message::find($message->id);
        $message->delete();

        return redirect('message')->with('Success', 'Message has been deleted');
    }
}
