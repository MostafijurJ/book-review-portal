<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the homepage
     */
    public function index()
    {
        $featuredBooks = Book::orderBy('average_rating', 'desc')
            ->where('total_reviews', '>', 0)
            ->take(6)
            ->get();

        $recentBooks = Book::latest()->take(6)->get();

        $genres = Book::select('genre')
            ->whereNotNull('genre')
            ->distinct()
            ->pluck('genre')
            ->filter()
            ->take(10);

        return view('home', compact('featuredBooks', 'recentBooks', 'genres'));
    }
}

