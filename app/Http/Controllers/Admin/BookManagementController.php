<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of books
     */
    public function index()
    {
        $books = Book::withCount('reviews')->latest()->paginate(20);
        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book
     */
    public function create()
    {
        $genres = Book::select('genre')->whereNotNull('genre')->distinct()->pluck('genre');
        return view('admin.books.create', compact('genres'));
    }

    /**
     * Store a newly created book
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'synopsis' => ['nullable', 'string'],
            'isbn' => ['nullable', 'string', 'unique:books,isbn'],
            'cover_image' => ['nullable', 'string', 'max:500'],
            'publication_date' => ['nullable', 'date'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'page_count' => ['nullable', 'integer', 'min:1'],
            'genre' => ['nullable', 'string', 'max:255'],
        ]);

        Book::create($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book created successfully!');
    }

    /**
     * Show the form for editing a book
     */
    public function edit(Book $book)
    {
        $genres = Book::select('genre')->whereNotNull('genre')->distinct()->pluck('genre');
        return view('admin.books.edit', compact('book', 'genres'));
    }

    /**
     * Update the specified book
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'synopsis' => ['nullable', 'string'],
            'isbn' => ['nullable', 'string', 'unique:books,isbn,' . $book->id],
            'cover_image' => ['nullable', 'string', 'max:500'],
            'publication_date' => ['nullable', 'date'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'page_count' => ['nullable', 'integer', 'min:1'],
            'genre' => ['nullable', 'string', 'max:255'],
        ]);

        $book->update($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book updated successfully!');
    }

    /**
     * Remove the specified book
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Book deleted successfully!');
    }
}

