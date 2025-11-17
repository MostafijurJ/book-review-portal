<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review
     */
    public function store(Request $request, Book $book)
    {
        // Check if user already reviewed this book
        $existingReview = Review::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->first();

        if ($existingReview) {
            return back()->withErrors(['review' => 'You have already reviewed this book.']);
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_text' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        $review = Review::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'rating' => $validated['rating'],
            'review_text' => $validated['review_text'],
            'is_approved' => true,
        ]);

        return back()->with('success', 'Your review has been submitted successfully!');
    }

    /**
     * Update the specified review
     */
    public function update(Request $request, Review $review)
    {
        // Ensure user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_text' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        $review->update($validated);

        return back()->with('success', 'Review updated successfully!');
    }

    /**
     * Remove the specified review
     */
    public function destroy(Review $review)
    {
        // Ensure user owns this review or is admin
        if ($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully!');
    }

    /**
     * Report a review
     */
    public function report(Request $request, Review $review)
    {
        $validated = $request->validate([
            'reason' => ['required', 'in:spam,inappropriate,harassment,other'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $review->reports()->create([
            'user_id' => Auth::id(),
            'reason' => $validated['reason'],
            'description' => $validated['description'] ?? null,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Thank you for reporting. We will review this content.');
    }
}

