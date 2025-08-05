<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BazarSchedule extends Model
{
    use HasFactory;

    protected $table = 'bazar_schedule';

    protected $fillable = [
        'user_id',
        'date',
        'status'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
