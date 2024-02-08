<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ThreadCategory;
use App\Models\Thread;

class ThreadCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $threadCategories = ThreadCategory::all();

        return view('cluster.index', compact('threadCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|min:2|max:255',
        ]);

        $threadCategory = new ThreadCategory();
        $threadCategory->category = $request->input('category');
        $threadCategory->save();

        return redirect()->route('cluster');
    }

    /**
     * Display the specified resource.
     */
    public function show($categoryId)
    {
        // Mengambil thread yang terkait dengan kategori ini
        $threadCategory = ThreadCategory::with(['threads.user'])
            ->findOrFail($categoryId);
        $threads = $threadCategory->threads()
            ->orderBy('created_at', 'DESC')
            ->paginate(5);

        return view('cluster.show', compact('threadCategory', 'threads'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ThreadCategory $threadCategory)
    {
        $editing = true;
        $threads = $threadCategory->threads()
            ->orderBy('created_at', 'DESC')
            ->paginate(5);

        return view('cluster.show', compact('threadCategory', 'threads', 'editing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ThreadCategory $threadCategory)
    {
        $request->validate([
            'category' => 'required|string|max:255',
        ]);

        $threadCategory->category = $request->input('category');

        $threadCategory->save();

        return redirect()->route('cluster');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ThreadCategory $threadCategory)
    {
        $threadCategory->delete();

        return redirect()->route('cluster.show');
    }

    public function getThreadsByID(ThreadCategory $threadCategory)
    {
        // Get the threads associated with the thread category
        $threads = $threadCategory->threads;

        // Return the threads
        return $threads;
    }

    public function search(Request $request)
    {
        $selectedCategories = $request->input('categories', []);

        $threads = Thread::whereHas('threadCategories', function ($query) use ($selectedCategories) {
            $query->whereIn('id', $selectedCategories);
        })
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('forum.shared.search_kategori', compact('threads'));
    }


    public function CategorySorting()
{
    $threadCategories = ThreadCategory::all();

    return view('forum.shared.category', compact('threadCategories'));
}

}
