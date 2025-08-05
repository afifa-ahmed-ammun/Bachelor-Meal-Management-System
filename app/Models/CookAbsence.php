<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CookAbsence extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'reason',
        'approved_by'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
