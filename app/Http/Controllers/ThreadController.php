<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
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

        return view('forum.dashboard', [
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
            'thread_category_id' => 'required',
        ]);

        $thread = new Thread;

        $thread->title = $request->title;
        $thread->content = $request->content;
        $thread->status = 'pending';
        $thread->created_at = now();
        $thread->created_by = Auth::user()->name;
        $thread->updated_at = now();
        $thread->updated_by = Auth::user()->name;
        $thread->user_id = auth()->id();
        $thread->forum_type_id = '1';
        $thread->thread_category_id = $request->thread_category_id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('your_storage_path', $fileName);
            $thread->file = $fileName;
        }

        $thread->save();


        return redirect('/forum')->with('success', 'Thread created successfully, wait for admin approval!');
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
        $thread->updated_at = now();
        $thread->save();

        return redirect()->route('threads.show', $thread->id)->with('success', 'Thread updated successfully!');
    }
}

