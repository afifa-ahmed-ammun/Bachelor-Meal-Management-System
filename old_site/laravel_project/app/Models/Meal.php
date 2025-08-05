<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'price',
        'date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2',
    ];

    /**
     * Get the user that created the meal.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the meal items for the meal.
     */
    public function mealItems()
    {
        return $this->hasMany(MealItem::class);
    }

    /**
     * Get the scheduled meals for the meal.
     */
    public function scheduledMeals()
    {
        return $this->hasMany(ScheduledMeal::class);
    }

    /**
     * Get the ratings for the meal.
     */
    public function ratings()
    {
        return $this->hasMany(MealRating::class);
    }
}
