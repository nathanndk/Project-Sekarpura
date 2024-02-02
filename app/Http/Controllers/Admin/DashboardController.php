<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Thread;
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

        return view('admin.dashboard', [
            'threads' => $threads,
        ]);
    }

    public function approve(Thread $thread)
{
    $this->authorize('thread.approve');

    $thread->update(['status' => 'approved']);

    return redirect()->route('admin.dashboard')->with('success', 'Thread approved successfully.');
}

    public function reject(Thread $thread)
    {
        $this->authorize('thread.reject');

        $thread->update(['status' => 'rejected']);

        return redirect()->route('admin.dashboard')->with('success', 'Thread rejected successfully.');
    }
}
