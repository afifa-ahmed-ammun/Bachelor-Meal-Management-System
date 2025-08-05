<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'quantity',
        'unit_type',
        'price',
        'threshold',
        'status',
        'requested_by',
        'requested_at'
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'price' => 'decimal:2',
        'threshold' => 'decimal:2',
        'requested_at' => 'datetime'
    ];

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
