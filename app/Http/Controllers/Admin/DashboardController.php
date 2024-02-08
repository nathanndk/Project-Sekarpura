<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Models\Notification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $threads = Thread::where('status', 'pending')
            ->orderBy('created_at', 'DESC');

        // Pencarian Thread
        if (request()->has('search')) {
            $searchTerm = request()->get('search', '');
            $threads = $threads->where('title', 'like', '%' . $searchTerm . '%')
                ->orWhere('content', 'like', '%' . $searchTerm . '%');
        }

        // Ambil hasil query
        $threads = $threads->paginate(5);

        return view('admin.index', [
            'threads' => $threads,
        ]);
    }

    public function approve(Thread $thread)
    {
        $this->authorize('thread.approve');

        $thread->update(['status' => 'approved']);

        // Buat notifikasi
        $notification = new Notification;
        $notification->ref_id = $thread->id;
        $notification->modules = 'approved';
        $notification->keterangan = 'Your thread "' . $thread->title . '" has been approved.';
        $notification->isRead = 0;
        $notification->created_at = now();
        $notification->updated_at = now();
        $notification->user_id = $thread->user_id;

        $notification->save();

        return redirect()->route('admin.index')->with('success', 'Thread approved successfully.');
    }

    public function reject(Thread $thread)
    {
        $this->authorize('thread.reject');

        $thread->update(['status' => 'rejected']);

        // Buat notifikasi
        $notification = new Notification;
        $notification->ref_id = $thread->id;
        $notification->modules = 'rejected';
        $notification->keterangan = 'Your thread titled "' . $thread->title . '" has been rejected.';
        $notification->isRead = 0;
        $notification->created_at = now();
        $notification->updated_at = now();
        $notification->user_id = $thread->user_id;

        $notification->save();

        return redirect()->route('admin.index')->with('success', 'Thread rejected successfully.');
    }
}
