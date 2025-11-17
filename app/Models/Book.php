<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'author',
        'synopsis',
        'isbn',
        'cover_image',
        'publication_date',
        'publisher',
        'page_count',
        'genre',
        'average_rating',
        'total_reviews',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'publication_date' => 'date',
        'average_rating' => 'decimal:2',
    ];

    /**
     * Get all reviews for this book
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true)->orderBy('created_at', 'desc');
    }

    /**
     * Get all reviews including unapproved
     */
    public function allReviews(): HasMany
    {
        return $this->hasMany(Review::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get all users who have this book on their bookshelf
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookshelves')
            ->withPivot('status', 'date_added', 'date_started', 'date_finished')
            ->withTimestamps();
    }

    /**
     * Update book's average rating and total reviews count
     */
    public function updateRatingStats(): void
    {
        $approvedReviews = $this->allReviews()->where('is_approved', true);
        $this->total_reviews = $approvedReviews->count();
        
        if ($this->total_reviews > 0) {
            $this->average_rating = $approvedReviews->avg('rating');
        } else {
            $this->average_rating = 0.00;
        }
        
        $this->save();
    }
}

