<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the specified user's public profile
     */
    public function show(User $user)
    {
        $user->load(['reviews.book', 'bookshelves.book']);

        $bookshelves = $user->bookshelves()
            ->with('book')
            ->get()
            ->groupBy('status');

        return view('profiles.show', compact('user', 'bookshelves'));
    }

    /**
     * Show the edit profile form
     */
    public function edit()
    {
        return view('profiles.edit');
    }

    /**
     * Update the user's profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }
}

