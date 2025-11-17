<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookshelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookshelfController extends Controller
{
    /**
     * Add or update a book on user's bookshelf
     */
    public function store(Request $request, Book $book)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:want_to_read,currently_reading,read'],
        ]);

        $bookshelf = Bookshelf::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'book_id' => $book->id,
            ],
            [
                'status' => $validated['status'],
                'date_added' => now(),
            ]
        );

        $statusLabels = [
            'want_to_read' => 'Want to Read',
            'currently_reading' => 'Currently Reading',
            'read' => 'Read',
        ];

        return back()->with('success', "Book added to '{$statusLabels[$validated['status']]}' shelf!");
    }

    /**
     * Update bookshelf status
     */
    public function update(Request $request, Bookshelf $bookshelf)
    {
        // Ensure user owns this bookshelf entry
        if ($bookshelf->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:want_to_read,currently_reading,read'],
        ]);

        $bookshelf->update($validated);

        return back()->with('success', 'Bookshelf updated successfully!');
    }

    /**
     * Remove book from bookshelf
     */
    public function destroy(Bookshelf $bookshelf)
    {
        // Ensure user owns this bookshelf entry
        if ($bookshelf->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $bookshelf->delete();

        return back()->with('success', 'Book removed from your bookshelf.');
    }

    /**
     * Show user's bookshelves
     */
    public function index()
    {
        $bookshelves = Bookshelf::where('user_id', Auth::id())
            ->with('book')
            ->get()
            ->groupBy('status');

        return view('bookshelves.index', compact('bookshelves'));
    }
}

