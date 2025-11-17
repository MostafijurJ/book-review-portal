<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookshelf extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'date_added',
        'date_started',
        'date_finished',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_added' => 'date',
        'date_started' => 'date',
        'date_finished' => 'date',
    ];

    /**
     * Get the user who owns this bookshelf entry
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book on this bookshelf
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Set dates based on status
        static::saving(function ($bookshelf) {
            if ($bookshelf->isDirty('status')) {
                $now = now();
                
                if ($bookshelf->status === 'currently_reading' && !$bookshelf->date_started) {
                    $bookshelf->date_started = $now;
                } elseif ($bookshelf->status === 'read' && !$bookshelf->date_finished) {
                    $bookshelf->date_finished = $now;
                    if (!$bookshelf->date_started) {
                        $bookshelf->date_started = $now;
                    }
                }
            }
        });
    }
}

