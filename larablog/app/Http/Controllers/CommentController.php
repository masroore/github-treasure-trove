<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    /**
     * CommentController constructor.
     */
    public function __construct()
    {
        $this->middleware('verified')->except('store');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($post_id)
    {
        request()->validate([
            'name' => 'required | max:255',
            'email' => 'required | email | max:255',
            'comment' => 'required | max:2000 ',
        ]);

        $post = Post::findOrFail($post_id);
        $comment = new Comment();
        $comment->name = request()->name;
        $comment->email = request()->email;
        $comment->avatar = 'https://www.gravatar.com/avatar/' . md5(Str::of(request()->email)->trim()->lower()) . '?s=60&d=monsterid';
        $comment->comment = request()->comment;
        $comment->approved = true;
        $comment->post()->associate($post);

        $comment->save();

        $notification = [
            'message' => 'Comment done.',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        $notification = [
            'message' => 'Congrats! Comment deleted.',
            'alert-type' => 'success',
        ];

        // Return to previews page
        return redirect()->back()->with($notification);
    }
}
