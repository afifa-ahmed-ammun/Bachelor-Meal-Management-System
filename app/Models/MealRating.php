<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MealRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'meal_id',
        'user_id',
        'rating'
    ];

    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
