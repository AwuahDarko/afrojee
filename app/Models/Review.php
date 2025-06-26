<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'product_name',
        'rating',
        'title',
        'review',
        'image',
        'status',
        'is_featured',
        'approved_at',
        'approved_by'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'is_featured' => 'boolean',
        'rating' => 'integer'
    ];

    // Relationships
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopeApproved(Builder $query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending(Builder $query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected(Builder $query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeFeatured(Builder $query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByRating(Builder $query, int $rating)
    {
        return $query->where('rating', $rating);
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'approved' => '<span class="badge bg-gradient-success">Approved</span>',
            'pending' => '<span class="badge bg-gradient-warning">Pending</span>',
            'rejected' => '<span class="badge bg-gradient-danger">Rejected</span>',
            default => '<span class="badge bg-gradient-secondary">Unknown</span>'
        };
    }

    public function getRatingStarsAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $stars .= '<i class="far fa-star text-muted"></i>';
            }
        }
        return $stars;
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/reviews/' . $this->image);
        }
        return null;
    }

    // Methods
    public function approve($userId = null)
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $userId ?? auth()->id()
        ]);
    }

    public function reject()
    {
        $this->update([
            'status' => 'rejected',
            'approved_at' => null,
            'approved_by' => null
        ]);
    }

    public function toggleFeatured()
    {
        $this->update(['is_featured' => !$this->is_featured]);
    }
}
