<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
                                      ->orderBy('created_at', 'desc')
                                      ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
                    ->where('is_read', false)
                    ->update([
                        'is_read' => true,
                        'read_at' => now(),
                    ]);

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function getUnreadNotificationsCount()
    {
        $unreadCount = Notification::where('user_id', auth()->id())
                                ->where('is_read', false)
                                ->count();

        return response()->json(['unread_count' => $unreadCount]);
    }

    public function getUnreadNotifications()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications);
    }



}
