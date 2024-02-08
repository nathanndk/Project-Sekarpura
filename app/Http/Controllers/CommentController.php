<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Thread;
use App\Models\Notification;

class CommentController extends Controller
{
    public function store(Thread $thread)
    {
        $comment = new Comment();
        $comment->content = request()->get('content');
        $comment->created_by = auth()->user()->name;
        $comment->user_id = auth()->id();
        $comment->thread_id = $thread->id;
        $comment->updated_by = auth()->user()->name;

        $comment->save();

        // Cek apakah pengguna yang dikomentari adalah pemilik thread
        if ($thread->user_id != auth()->id()) {

            // Buat notifikasi hanya jika pengguna yang dikomentari adalah pemilik thread
            $notification = new Notification;
            $notification->ref_id = $thread->id;
            $notification->modules = 'comments';
            $notification->keterangan = auth()->user()->name . ' commented on your post: "' . $comment->content . '"';
            $notification->isRead = 0;
            $notification->created_at = now();
            $notification->updated_at = now();
            $notification->user_id = $thread->user_id;

            $notification->save();
        }

        return redirect()->route('threads.show', $thread->id)->with('success', 'Comment created successfully!');
    }

}


