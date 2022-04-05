<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(): void
    {
    }

    public function messageSave(Request $request)
    {
        $sender = $request->sender;
        $receiver = $request->receiver;
        $content = $request->content;

        $msgdata = [
            'sender' => $sender,
            'receiver' => $receiver,
            'content' => $content,
            'status' => $receiver,
        ];

        DB::table('messages')->insert($msgdata);

        return json_encode('New Message added successfully');
    }

    public function getNewMsg(Request $request)
    {
        $newMsg = DB::table('message')->where('status', '=', 0)->get();

        return json_encode($newMsg);
    }

    public function getMessages(Request $request)
    {
        $res = DB::table('messages')
            ->where(function ($q) use ($request): void {
                $q->where('sender', $request->myid)
                    ->where('receiver', $request->oppid);
            })->orWhere(function ($q) use ($request): void {
                $q->where('sender', $request->oppid)
                    ->where('receiver', $request->myid);
            })->orderby('msg_date', 'asc')->limit(100)->get();

        DB::table('messages')->where('sender', $request->oppid)->where('receiver', $request->myid)->update(['status' => 0]);

        return json_encode($res);
    }
}
