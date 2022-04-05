<?php

namespace App\Http\Controllers\Api;

use App\Events\DeleteMessage;
use App\Events\NewChatMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChatStoreMessage;
use App\Http\Requests\ChatUpdateMessage;
use App\Http\Resources\ConversationInfoResource;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Notify;
use App\Models\User;
use App\Notifications\NewMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB as DBAlias;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @api {post} /api/v1/messages 1. Одправить сообщение юзеру
     * @apiVersion 1.0.0
     * @apiName ChatStoreMessage
     * @apiGroup 16.Чат
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {Int} second Id юзера которому одправляете письмо
     * @apiParam {String} message Текст сообщения
     * @apiParam {Array} [docs] Вложенные файлы в сообщение
     */
    public function sendMessage(ChatStoreMessage $request)
    {
        $firstUser = auth()->user();
        $secondUser = User::findOrFail($request->second);

        if ($secondUser->checkBanUser($firstUser->id)) {
            return response()->json(['data' => trans('system.chat.banned')], Response::HTTP_FORBIDDEN);
        }

        if ($this->checkValidAddressee($firstUser, $secondUser)) {
            return response()->json(['data' => trans('system.chat.self')], Response::HTTP_BAD_REQUEST);
        }

        $conversation = $this->getConversations($firstUser->id, $secondUser->id);

        if ($request->get('message')) {
            $message = Message::create([
                'conv_id' => $conversation->id,
                'sender' => $firstUser->id,
                'addressee' => $secondUser->id,
                'readed' => false,
                'sender_delete' => false,
                'addressee_delete' => false,
                'message' => $request->message,
            ]);

            Notification::send($secondUser, new NewMessage($message, $firstUser));
            $message->notifies()->create([
                'user_id' => $secondUser->id,
                'type' => Notify::TYPE_MESSAGE,
                'text' => trans('notification.message.add'),
            ]);

            $this->addFilesForMessage($request, $message);
            $countNotReaded = Message::where('conv_id', $conversation->id)->where('readed', false)->count();
            $conversation->update([
                'last_message_id' => $message->id,
                'sender' => $firstUser->id,
                'unread' => $countNotReaded,
            ]);

            $message->load('senderData', 'addresseeData', 'media');

            broadcast(new NewChatMessage($message));

            return response()->json(['message' => trans('system.chat.message.send'), 'data' => MessageResource::make($message)], Response::HTTP_OK);
        }

        return response()->json(['message' => trans('system.chat.conversation.create'), 'data' => ['conv_id' => $conversation->id]], Response::HTTP_OK);
    }

    protected function getConversations($first, $second)
    {
        /** @var Conversation $conversation */
        $conversation = Conversation::where([
            ['first', '=', $first],
            ['second', '=', $second],
        ])->orWhere([
            ['first', '=', $second],
            ['second', '=', $first],
        ])->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'first' => $first,
                'second' => $second,
                'unread' => 0,
                'first_delete' => false,
                'second_delete' => false,
            ]);
        }

        //If the user has previously deleted the conversation, update it to show new messages
        if ($conversation->first_delete || $conversation->second_delete) {
            $conversation->update([
                'first_delete' => false,
                'second_delete' => false,
            ]);
        }

        return $conversation;
    }

    protected function checkValidAddressee($first, $second)
    {
        return $first->id === $second->id;
    }

    protected function addFilesForMessage($request, $message): void
    {
        if ($request->docs) {
            foreach ($request->docs as $file) {
                $message->addMedia($file)->toMediaCollection('docs');
            }
        }
    }

    /**
     * @api {get} /api/v1/conversations 2. Получить переписки с последним сообщениям
     * @apiVersion 1.0.0
     * @apiName getConversations
     * @apiGroup 16.Чат
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function getAllConversations()
    {
        $user = auth()->user();
        $conversations = Conversation::with('firstData', 'secondData', 'messages')->leftJoin('messages', 'conversations.last_message_id', '=', 'messages.id')
            ->whereHas('messages')
            ->where(function ($query) use ($user): void {
                $query->where('first', $user->id)->orWhere('second', $user->id);
            })
            ->whereRaw('CASE WHEN conversations.first = ? THEN conversations.first_delete = 0 WHEN conversations.second = ? THEN conversations.second_delete = 0 END', [$user->id, $user->id])
            ->select('conversations.id as id', 'conversations.first', 'conversations.second', 'conversations.sender', 'conversations.unread', 'messages.message', 'messages.created_at')
            ->orderByDesc('messages.created_at')
            ->get();

        return ConversationResource::collection($conversations);
    }

    /**
     * @api {get} /api/v1/conversations/{conv_id}/messages 3. Получить все сообщение переписки
     * @apiVersion 1.0.0
     * @apiName getChatMessages
     * @apiGroup 16.Чат
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function getAllMessagesForConversation($id)
    {
        $user = auth()->user();
        $conversation = Conversation::findOrFail($id);
        $messages = Message::with('senderData', 'addresseeData', 'media')->where('conv_id', $conversation->id)
            ->whereRaw('CASE WHEN messages.sender = ? THEN messages.sender_delete = 0 WHEN messages.addressee = ? THEN messages.addressee_delete = 0 END', [$user->id, $user->id])
            ->orderBy('created_at', 'asc')
            ->get();

        if ($conversation->sender != $user->id) {
            Message::where('conv_id', $conversation->id)->update([
                'readed' => true,
            ]);
            $conversation->update([
                'unread' => 0,
            ]);
        }

        return MessageResource::collection($messages);
    }

    /**
     * @api {delete} /api/v1/conversations/{conv_id} 4. Удалить переписку
     * @apiVersion 1.0.0
     * @apiName deleteConversations
     * @apiGroup 16.Чат
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function deleteConversations($id)
    {
        $user = auth()->user();
        $conversation = Conversation::findOrFail($id);

        DBAlias::select(DBAlias::raw('UPDATE messages SET sender_delete = CASE sender WHEN ' . $user->id . ' THEN 1 ELSE sender_delete END, addressee_delete = CASE addressee WHEN ' . $user->id . ' THEN 1 ELSE addressee_delete END WHERE conv_id = ' . $conversation->id . ' '));
        DBAlias::select(DBAlias::raw('UPDATE conversations SET first_delete = CASE first WHEN ' . $user->id . ' THEN 1 ELSE first_delete END, second_delete = CASE second WHEN ' . $user->id . ' THEN 1 ELSE second_delete END WHERE id = ' . $conversation->id . ' '));

        return response()->json(['message' => trans('system.chat.conversation.delete')], Response::HTTP_OK);
    }

    /**
     * @api {post} /api/v1/conversations/{conv_id}/reads 5. Отметить как прочитанное
     * @apiVersion 1.0.0
     * @apiName markMessageReads
     * @apiGroup 16.Чат
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function messageMarksRead($id)
    {
        $user = auth()->user();
        $conversation = Conversation::findOrFail($id);

        if ($conversation->unread && $conversation->sender != $user->id) {
            $conversation->update([
                'unread' => 0,
                'last_notify_time' => Carbon::now(),
            ]);
            $message = Message::where('conv_id', $id)->where('addressee', $user->id)->update([
                'readed' => true,
            ]);
            $message->notifies()->delete();
        }

        return response()->json(['message' => trans('system.chat.read')], Response::HTTP_OK);
    }

    /**
     * @api {put/patch} /api/v1/messages/{id} 6. Обновить сообщение
     * @apiVersion 1.0.0
     * @apiName updateMessage
     * @apiGroup 16.Чат
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     *
     * @apiParam {String} message Текст сообщение
     * @apiParam {Array} [docs] Вложенные файлы в сообщение
     */
    public function updateMessage($id, ChatUpdateMessage $request)
    {
        $message = Message::findOrFail($id);

        if (Gate::denies('message-update', $message)) {
            return response()->json(['message' => trans('system.chat.denies')], Response::HTTP_BAD_REQUEST);
        }

        $message->update([
            'message' => $request->message,
        ]);

        broadcast(new NewChatMessage($message));
        $this->addFilesForMessage($request, $message);

        return response()->json(['message' => trans('system.chat.message.update'), 'data' => $message], Response::HTTP_OK);
    }

    /**
     * @api {delete} /api/v1/messages/{id} 7. Удалить сообщение
     * @apiVersion 1.0.0
     * @apiName deleteMessage
     * @apiGroup 16.Чат
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function deleteMessage($id)
    {
        $message = Message::findOrFail($id);

        if (Gate::denies('message-delete', $message)) {
            return response()->json(['message' => trans('system.chat.denies')], Response::HTTP_BAD_REQUEST);
        }

        broadcast(new DeleteMessage($message->id));

        $message->notifies()->delete();

        $message->delete();

        // change last message id if drop last message
        $conversation = $message->conversation;

        if ($id == $conversation->last_message_id) {
            $lastMessages = $conversation->messages->last();
            $conversation->last_message_id = $lastMessages->id;
            $conversation->save();
        }

        return response()->json(['message' => trans('system.chat.message.delete')], Response::HTTP_OK);
    }

    /**
     * @api {get} /api/v1/messages/unread 8. Количество непрочитанных диалогов
     * @apiVersion 1.0.0
     * @apiName getUnreadMessages
     * @apiGroup 16.Чат
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function unreadCount(Request $request)
    {
        $user = auth()->user();
        $unreadCount = Conversation::where('unread', '>', 0)->where('sender', '<>', $user->id)
            ->where(function ($query) use ($user): void {
                $query->where('first', $user->id)->orWhere('second', $user->id);
            })
            ->whereRaw('CASE WHEN first = ? THEN first_delete = 0 WHEN second = ? THEN second_delete = 0 END', [$user->id, $user->id])
            ->count();

        return $unreadCount;
    }

    /**
     * @api {get} /api/v1/conversations/{id}/info 9. Получиить conversation по id
     * @apiVersion 1.0.0
     * @apiName getInfoConversation
     * @apiGroup 16.Чат
     * @apiHeader {String} Authorization Bearer токен пользователя <code>Bearer eyJ0eXAiOiJKV1Qi...</code>
     */
    public function getInfoConversation(Request $request, $id)
    {
        $conversation = Conversation::with('firstData', 'secondData')->findOrFail($id);

        return response()->json(['message' => trans('system.chat.conversation.create'), 'data' => ConversationInfoResource::make($conversation)], Response::HTTP_OK);
    }
}
