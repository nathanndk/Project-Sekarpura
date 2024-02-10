<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mendapatkan ID pengguna yang sedang masuk
        $userId = Auth::id();

        // Mendapatkan notifikasi yang ditujukan ke pengguna saat ini, diurutkan dari yang terbaru
        $notifications = Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        // Mengembalikan tampilan dengan data notifikasi
        return view('notifications.index', compact('notifications'));
    }


    /**
     * Update the specified notification status to mark it as read.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Notification $notification)
    {
        // Memastikan bahwa pengguna yang mencoba memperbarui notifikasi adalah pemiliknya
        if ($notification->user_id !== Auth::id()) {
            abort(403); // Kode akses tidak diizinkan
        }

        $notification->update(['isRead' => true]);

        // Retrieve the thread associated with the notification
        $thread = Thread::find($notification->ref_id);

        // Memastikan thread ditemukan
        if (!$thread) {
            return redirect()->route('notifications')->with('error', 'Thread not found!');
        }

        return redirect()->route('threads.show', $thread->id);
    }

    public function profile()
    {
        // Mendapatkan ID pengguna yang sedang masuk
        $userId = Auth::id();

        // Mendapatkan notifikasi yang dibuat oleh pengguna saat ini, diurutkan dari yang terbaru
        $notifications = Notification::where('created_by', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Mengembalikan tampilan dengan data notifikasi
        return view('notifications.index', compact('notifications'));
    }

}
