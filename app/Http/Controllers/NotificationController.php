<?php

namespace App\Http\Controllers;

use App\Models\Notif;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Menampilkan daftar notifikasi.
     */
    public function index()
    {
        $notif = Notification::all();
        return response()->json($notif);
    }

    /**
     * Menyimpan notifikasi baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:255',
            'date' => 'required|date',
            'created_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $notif = Notification::create([
            'message' => $request->message,
            'date' => $request->date,
            'created_id' => $request->created_id,
            'updated_id' => $request->created_id, // Default updated_id sama dengan created_id
        ]);

        return response()->json(['message' => 'Notification created successfully', 'notification' => $notif], 201);
    }

    /**
     * Menampilkan detail notifikasi tertentu.
     */
    public function show($id)
    {
        $notif = Notification::find($id);

        if (!$notif) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        return response()->json($notif);
    }

    /**
     * Memperbarui notifikasi tertentu.
     */
    public function update(Request $request, $id)
    {
        $notif = Notification::find($id);

        if (!$notif) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'string|max:255',
            'date' => 'date',
            'updated_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $notif->update([
            'message' => $request->message ?? $notif->message,
            'date' => $request->date ?? $notif->date,
            'updated_id' => $request->updated_id,
        ]);

        return response()->json(['message' => 'Notification updated successfully', 'notification' => $notif]);
    }

    public function delete($id)
    {
        $notif = Notification::find($id);

        if (!$notif) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        $notif->update(['deleted_id' => Auth::id(),]);
        $notif->delete();

        return response()->json(['message' => 'Notification deleted successfully']);
    }

    public function restore($id)
    {
        $notif = Notification::onlyTrashed()->find($id);

        if (!$notif) {
            return response()->json(['message' => 'Notification not found in trash'], 404);
        }

        $notif->restore();

        return response()->json(['message' => 'Notification restored successfully', 'notification' => $notif]);
    }

    /**
     * Menghapus notifikasi secara permanen.
     */
    public function forceDelete($id)
    {
        $notif = Notification::onlyTrashed()->find($id);

        if (!$notif) {
            return response()->json(['message' => 'Notification not found in trash'], 404);
        }

        $notif->forceDelete();

        return response()->json(['message' => 'Notification permanently deleted']);
    }
}
