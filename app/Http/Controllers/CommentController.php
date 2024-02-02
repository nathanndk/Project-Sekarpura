<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Thread $thread)
    {

        $comment = new Comment();
        $comment->content = request()->get('content');
        $comment->created_by =Auth::user()->name;
        $comment->user_id = auth()->id();
        $comment->thread_id = $thread->id;
        $comment->updated_by = Auth::user()->name;

        $comment->save();

        return redirect()->route('threads.show', $thread->id)->with('success', 'Comment created successfully!');
    }
}


