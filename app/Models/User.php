<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'status',
        'bio',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the default status value
     */
    protected $attributes = [
        'status' => 'active',
    ];

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a member
     */
    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    /**
     * Get all reviews by this user
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get all bookshelves for this user
     */
    public function bookshelves(): HasMany
    {
        return $this->hasMany(Bookshelf::class);
    }

    /**
     * Get all reports made by this user
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Get books on user's bookshelf
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'bookshelves')
            ->withPivot('status', 'date_added', 'date_started', 'date_finished')
            ->withTimestamps();
    }
}

