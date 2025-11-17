<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'reportable_type',
        'reportable_id',
        'reason',
        'description',
        'status',
        'resolved_by',
        'resolved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Get the user who made this report
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who resolved this report
     */
    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Get the reportable model (polymorphic)
     */
    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Mark report as resolved
     */
    public function markAsResolved(User $admin): void
    {
        $this->status = 'resolved';
        $this->resolved_by = $admin->id;
        $this->resolved_at = now();
        $this->save();
    }

    /**
     * Dismiss the report
     */
    public function dismiss(User $admin): void
    {
        $this->status = 'dismissed';
        $this->resolved_by = $admin->id;
        $this->resolved_at = now();
        $this->save();
    }
}

