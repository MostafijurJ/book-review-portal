<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenreManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of genres
     */
    public function index()
    {
        $genres = Book::select('genre', DB::raw('COUNT(*) as book_count'))
            ->whereNotNull('genre')
            ->groupBy('genre')
            ->orderBy('genre')
            ->paginate(20);

        return view('admin.genres.index', compact('genres'));
    }

    /**
     * Show the form for creating a new genre
     */
    public function create()
    {
        return view('admin.genres.create');
    }

    /**
     * Store a newly created genre (just redirects, genres are created when books are added)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'genre' => ['required', 'string', 'max:255'],
        ]);

        // Genres are created when books are added, so we just redirect
        return redirect()->route('admin.genres.index')
            ->with('info', 'Genre will be created when you add a book with this genre.');
    }

    /**
     * Show the form for editing a genre
     */
    public function edit($genre)
    {
        $books = Book::where('genre', $genre)->get();
        return view('admin.genres.edit', compact('genre', 'books'));
    }

    /**
     * Update the specified genre (rename all books with this genre)
     */
    public function update(Request $request, $oldGenre)
    {
        $validated = $request->validate([
            'genre' => ['required', 'string', 'max:255'],
        ]);

        Book::where('genre', $oldGenre)
            ->update(['genre' => $validated['genre']]);

        return redirect()->route('admin.genres.index')
            ->with('success', 'Genre updated successfully!');
    }

    /**
     * Remove the specified genre (remove genre from all books)
     */
    public function destroy($genre)
    {
        $bookCount = Book::where('genre', $genre)->count();
        Book::where('genre', $genre)->update(['genre' => null]);

        return redirect()->route('admin.genres.index')
            ->with('success', "Genre removed from {$bookCount} book(s) successfully!");
    }
}

