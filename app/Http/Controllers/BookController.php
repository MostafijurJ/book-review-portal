<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use App\Models\Bookshelf;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of books (search/browse)
     */
    public function index(Request $request)
    {
        $query = Book::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Filter by genre
        if ($request->has('genre') && $request->genre) {
            $query->where('genre', $request->genre);
        }

        $books = $query->orderBy('created_at', 'desc')->paginate(12);

        $genres = Book::select('genre')
            ->whereNotNull('genre')
            ->distinct()
            ->pluck('genre')
            ->filter();

        return view('books.index', compact('books', 'genres'));
    }

    /**
     * Display the specified book
     */
    public function show(Book $book)
    {
        $book->load(['reviews.user', 'reviews' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        $userBookshelf = null;
        if (auth()->check()) {
            $userBookshelf = Bookshelf::where('user_id', auth()->id())
                ->where('book_id', $book->id)
                ->first();
        }

        return view('books.show', compact('book', 'userBookshelf'));
    }

    /**
     * Show genre page
     */
    public function genre($genre)
    {
        $books = Book::where('genre', $genre)
            ->orderBy('average_rating', 'desc')
            ->paginate(12);

        return view('books.genre', compact('books', 'genre'));
    }
}

