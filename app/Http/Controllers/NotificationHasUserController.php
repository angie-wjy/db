<?php

namespace App\Http\Controllers;

use App\Models\NotificationHasUser;
use Illuminate\Http\Request;

class NotificationHasUserController extends Controller
{
    public function index()
    {
        $NotifUser = NotificationHasUser::with(['notif', 'user'])->get();
        return response()->json($NotifUser);
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|exists:notifications,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $notifPromoUser = NotificationHasUser::create([
            'notification_id' => $request->notification_id,
            'user_id' => $request->user_id,
        ]);

        return response()->json(['message' => 'Notification Promo User added successfully', 'data' => $notifPromoUser], 201);
    }

    // Menampilkan satu data berdasarkan id
    public function show($notification_id, $user_id)
    {
        $notifPromoUser = NotificationHasUser::where('notification_id', $notification_id)
            ->where('user_id', $user_id)
            ->first();

        if (!$notifPromoUser) {
            return response()->json(['message' => 'Notification Promo User not found'], 404);
        }

        return response()->json($notifPromoUser);
    }

    // Mengupdate data
    public function update(Request $request, $notification_id, $user_id)
    {
        $notifPromoUser = NotificationHasUser::where('notification_id', $notification_id)
            ->where('user_id', $user_id)
            ->first();

        if (!$notifPromoUser) {
            return response()->json(['message' => 'Notification Promo User not found'], 404);
        }

        $request->validate([
            'notification_id' => 'required|exists:notifications,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $notifPromoUser->update([
            'notification_id' => $request->notification_id,
            'user_id' => $request->user_id,
        ]);

        return response()->json(['message' => 'Notification Promo User updated successfully', 'data' => $notifPromoUser]);
    }

    // Menghapus data
    public function destroy($notification_id, $user_id)
    {
        $notifPromoUser = NotificationHasUser::where('notification_id', $notification_id)
            ->where('user_id', $user_id)
            ->first();

        if (!$notifPromoUser) {
            return response()->json(['message' => 'Notification Promo User not found'], 404);
        }

        $notifPromoUser->delete();

        return response()->json(['message' => 'Notification Promo User deleted successfully']);
    }
}
