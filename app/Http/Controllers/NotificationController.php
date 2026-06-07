<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function read($id)
    {
        $notification = AppNotification::where('user_id', Auth::id())->findOrFail($id);

        if (!$notification->read_at) {
            $notification->update([
                'read_at' => now(),
            ]);
        }

        return redirect($notification->url);
    }
}
