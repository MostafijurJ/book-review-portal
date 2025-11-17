<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of authors
     */
    public function index()
    {
        $authors = Book::select('author', DB::raw('COUNT(*) as book_count'))
            ->groupBy('author')
            ->orderBy('author')
            ->paginate(20);

        return view('admin.authors.index', compact('authors'));
    }

    /**
     * Show the form for editing an author
     */
    public function edit($author)
    {
        $books = Book::where('author', $author)->get();
        return view('admin.authors.edit', compact('author', 'books'));
    }

    /**
     * Update the specified author (rename all books by this author)
     */
    public function update(Request $request, $oldAuthor)
    {
        $validated = $request->validate([
            'author' => ['required', 'string', 'max:255'],
        ]);

        Book::where('author', $oldAuthor)
            ->update(['author' => $validated['author']]);

        return redirect()->route('admin.authors.index')
            ->with('success', 'Author updated successfully!');
    }

    /**
     * Remove the specified author (delete all books by this author)
     */
    public function destroy($author)
    {
        $bookCount = Book::where('author', $author)->count();
        Book::where('author', $author)->delete();

        return redirect()->route('admin.authors.index')
            ->with('success', "Author and {$bookCount} book(s) deleted successfully!");
    }
}

