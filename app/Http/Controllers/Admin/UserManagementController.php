<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::withCount(['reviews', 'bookshelves'])
            ->where('role', 'member')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing a user
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'bio' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:active,suspended,banned'],
        ]);

        // Store status in a way we can check it
        // We'll add a status field to users table or use a different approach
        // For now, let's add it to the user model
        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Suspend a user
     */
    public function suspend(User $user)
    {
        $user->update(['status' => 'suspended']);
        return back()->with('success', 'User suspended successfully!');
    }

    /**
     * Ban a user
     */
    public function ban(User $user)
    {
        $user->update(['status' => 'banned']);
        return back()->with('success', 'User banned successfully!');
    }

    /**
     * Activate a user
     */
    public function activate(User $user)
    {
        $user->update(['status' => 'active']);
        return back()->with('success', 'User activated successfully!');
    }
}

