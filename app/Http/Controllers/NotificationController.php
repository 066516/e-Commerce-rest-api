<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\NewNotificationEvent;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'message' => 'required|string',
        ]);

        // Fetch the user
        $user = User::find($validatedData['user_id']);

        // Dispatch the event to notify the user
        event(new NewNotificationEvent($user->id, $validatedData['message']));

        return response()->json(['message' => 'Notification sent successfully!']);
    }
}
