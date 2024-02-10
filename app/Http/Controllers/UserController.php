<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Mendapatkan thread yang memiliki status "approved"
        $threads = $user->threads()->where('status', 'approved')->paginate(5);

        return view('users.show', compact('user', 'threads'));
    }

    public function edit(User $user)
    {
        // Mendapatkan thread yang memiliki status "approved"
        $threads = $user->threads()->where('status', 'approved')->paginate(5);

        $editing = true;

        return view('users.edit', compact('user', 'editing', 'threads'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user)
    {
        $validated = request()->validate([
            'name' => 'required|min:3|max:40',
            'bio' => 'nullable|min:3|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (request('image')) {
            $imagePath = request()->file('image')->store('profile', 'public');
            $validated['image'] = $imagePath;

            Storage::disk('public')->delete($user->image ?? '');
        }

        $user->update($validated);

        return redirect()->route('profile');
    }


    public function profile()
    {
        return $this->show(auth()->user());
    }

}
