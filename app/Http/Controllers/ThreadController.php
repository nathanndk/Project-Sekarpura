<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\ThreadCategory;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    public function index(Request $request)
    {
        $threads = Thread::where('status', 'approved')
            ->orderBy('created_at', 'DESC');

        // Pencarian Thread
        if ($request->has('search')) {
            $searchTerm = $request->get('search', '');
            $threads = $threads->where('title', 'like', '%' . $searchTerm . '%')
                ->orWhere('content', 'like', '%' . $searchTerm . '%');
        }

        // Ambil hasil query
        $threads = $threads->paginate(5);

        // Ccek forum type
        if ($request->has('forum_type')) {
            $forumType = $request->get('forum_type');
            return redirect()->route('forum', ['forum_type' => $forumType])->with('threads', $threads);
        }

        return view('forum.index', [
            'threads' => $threads,
        ]);
    }

    public function show(Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }

    public function edit(Thread $thread)
    {
        // if (auth()->user()->id !== $thread->user_id) {
        //     abort(404);
        // }

        $this->authorize('thread.edit', $thread);

        $editing = true;

        return view('threads.show', compact('thread', 'editing'));
    }

    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required|min:5|max:30',
            'content' => 'required|min:5|max:254',
            // 'thread_category_id' => 'required',
        ]);

        $thread = new Thread;
        $thread->title = $request->title;
        $thread->content = $request->content;
        $thread->status = auth()->user()->role == 3 ? 'approved' : 'pending';
        $thread->created_at = now();
        $thread->created_by = auth()->id();
        $thread->updated_at = now();
        $thread->updated_by = auth()->id();
        $thread->user_id = auth()->id();
        $thread->forum_type_id = '1';
        $thread->thread_category_id = $request->thread_category_id;

        $thread->save();

        // Mendapatkan pengguna dengan peran (role) 3
        $adminUser = User::where('role', 3)->first();

        // Buat notifikasi
        $notification = new Notification;
        $notification->ref_id = $thread->id; // ID thread yang baru saja dibuat
        $notification->modules = 'threads';
        $notification->keterangan = auth()->user()->name . ' request to make a thread: "' . $thread->title . '"';
        $notification->isRead = 0;
        $notification->created_at = now();
        $notification->updated_at = now();
        $notification->user_id = $adminUser->id;

        $notification->save();

        $approvalMessage = auth()->user()->role == 3 ? 'Thread created successfully!' : 'Thread created successfully, wait for admin approval!';

        return redirect('/threads')->with('success', $approvalMessage);
    }

    public function destroy(Thread $thread)
    {
        $this->authorize('thread.delete', $thread);

        $thread->delete();

        return redirect('/forum')->with('success', 'Thread deleted successfully!');
    }

    public function update(Request $request, Thread $thread)
    {
        $this->authorize('thread.edit', $thread);

        request()->validate([
            'title' => 'required|min:5|max:30',
            'content' => 'required|min:5|max:254',
        ]);

        $thread->title = $request->input('title', '');
        $thread->content = $request->input('content', '');

        if (auth()->user()->role == 3) {
            $thread->status = 'approved';
        } else {
            $thread->status = 'pending';
        }

        $thread->updated_at = now();
        $thread->save();

        return redirect()->route('forum')->with('success', 'Thread updated' . ($thread->status == 'approved' ? ' and approved!' : ', wait for admin approval!'));
    }

    public function getCategory()
    {
        $threadCategories = ThreadCategory::all();

        return view('threads.shared.submit_thread', compact('threadCategories'));
    }

}
