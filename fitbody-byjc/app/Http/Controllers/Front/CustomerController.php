<?php

namespace App\Http\Controllers\Front;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Back\Users\Message;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (!auth()->user()) {
            return redirect()->route('register');
        }

        $customer = auth()->user();

        $query = (new Message())->newQuery();
        $messages = $query->inbox()->orderBy('created_at', 'desc')->with('sender', 'recipient')->paginate(20);

        return view('front.customer.index', compact('customer', 'messages'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $customer = auth()->user();

        return view('front.customer.edit', compact('customer'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request)
    {
        $customer = auth()->user();
        $updated = $customer->validateCustomerRequest($request)->updateCustomerData($customer->id);

        return redirect()->route('moj.edit')->with(['success' => 'Korisnički podaci uspješno obnovljeni..!']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function messages()
    {
        $customer = auth()->user();

        $query = (new Message())->newQuery();
        $messages = $query->inbox()->orderBy('created_at', 'desc')->with('sender', 'recipient')->paginate(20);

        return view('front.customer.messages', compact('customer', 'messages'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newMessage()
    {
        $customer = auth()->user();

        return view('front.customer.message', compact('customer'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewMessage(Message $message)
    {
        $query = (new Message())->newQuery();

        $messages = $query->conversation($message)
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->get();

        $customer = auth()->user();
        $recipient = Message::getRecipientUser($message);

        return view('front.customer.message', compact('customer', 'messages', 'recipient'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request)
    {
        if (!$request->has('recipient')) {
            $request->recipient = $request->input('user_id');
        }

        $message = new Message();
        $message_stored = $message->validateRequest($request)->storeData();

        event(new MessageSent($message_stored));

        if ($message_stored) {
            return redirect()->route('moj.poruke')->with(['success' => 'Poruka je uspješno poslana.!']);
        }

        return redirect()->back()->with(['error' => 'Whoops..! Došlo je do greške sa snimanjem poruke.']);
    }
}
