<?php

namespace App\Http\Controllers;

use App\Models\Thread;

class ThreadUserController extends Controller
{
    public function store(Thread $thread)
    {
        $liker = auth()->user();

        $liker->likes()->attach($thread);

        return redirect()->route('forum')->with('success', "Liked successfully!");
    }

    public function delete(Thread $thread)
    {
        $liker = auth()->user();

        $liker->likes()->detach($thread);

        return redirect()->route('forum')->with('success', "Unliked successfully!");
    }

}

