<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd( $request->all());

        $this->validate($request, [
            'customer_id' => 'required|integer',
            'content' => 'required|string|min:2|max:1000',
        ]);

        $customer_id = $request->customer_id;
        $content = $request->content;

        if (Auth::check() && Auth::user()->isAdmin()) {
            $user = Auth::user();
            $name = $user->nick;
        } else {
            $customer = Customer::find($customer_id);

            $key = 'cust-pass-' . $customer->id;
            if (session()->get($key) != 'ok') {
                return redirect()->back()->with('error', '권한이 없습니다.');
            }
            $name = $customer->name;
        }

        $comment = new Comment();
        if (isset($user)) {
            $comment->user_id = $user->id;
        }
        $comment->customer_id = $customer_id;
        $comment->name = $name;
        $comment->content = $content;
        $comment->save();

        return redirect()->route('customers.show', [
            'customer' => $customer_id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {

    }
}
