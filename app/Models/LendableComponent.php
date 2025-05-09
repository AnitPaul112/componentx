<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LendableComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'image_url',
        'deposit_amount',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'deposit_amount' => 'decimal:2',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lendingRequests(): HasMany
    {
        return $this->hasMany(LendingRequest::class);
    }
} 