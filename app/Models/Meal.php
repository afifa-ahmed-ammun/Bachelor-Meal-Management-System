<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'meal_type',
        'meal_name',
        'quantity',
        'price'
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(MealRating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
}
