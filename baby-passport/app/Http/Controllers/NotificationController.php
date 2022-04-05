<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Auth;
use Illuminate\Database\QueryException;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $notifications = Notification::where('receiver', Auth::user()->type)
            ->where('read', 0)
            ->orWhere('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($notifications as $notification) {
            $notification->date = $notification->created_at->format('d F Y h:i a');
        }

        return response()->json(['notifications' => $notifications], 200);
    }

    public function markAsRead($id)
    {
        try {
            $notification = Notification::find($id);
            if (empty($notification)) {
                return response()->json(['message' => 'No se encontró la notificación'], 404);
            }

            $notification->update([
                'read' => 1,
            ]);

            return response()->json(['message' => 'Notificación marcada como leída'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Hubo un error al marcar la notificación como leída'], 500);
        }
    }
}
