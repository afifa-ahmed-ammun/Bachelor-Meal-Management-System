<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledMeal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'meal_id',
        'scheduled_date',
        'meal_time',
        'quantity',
        'total_price',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'scheduled_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the scheduled meal.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the meal associated with this scheduled meal.
     */
    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }
}
