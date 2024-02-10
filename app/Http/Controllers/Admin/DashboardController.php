<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Models\Notification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Validasi input
        $request->validate([
            'forum_type_id' => 'required|integer',
        ]);

        // Mulai query dengan filter status pending dan forum type id
        $threads = Thread::where('status', 'pending')
            ->where('forum_type_id', $request->forum_type_id)
            ->orderBy('created_at', 'DESC');

        // Pencarian Thread
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $threads->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('content', 'like', '%' . $searchTerm . '%');
            });
        }

        // Ambil hasil query dengan pagination
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
        $notification->created_by = auth()->user()->id;
        $notification->updated_at = now();
        $notification->user_id = $thread->user_id;

        $notification->save();

        return redirect()->route('admin.approval')->with('success', 'Thread approved successfully.');
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
        $notification->created_by = auth()->user()->id;
        $notification->updated_at = now();
        $notification->user_id = $thread->user_id;

        $notification->save();

        return redirect()->route('admin.approval')->with('success', 'Thread rejected successfully.');
    }
}
