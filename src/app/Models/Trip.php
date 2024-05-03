<?php

namespace App\Models;

use App\Enums\TripStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_id',
        'order_id',
        'status',
        'delivered_at',
    ];

    protected $casts = [
        'status' => TripStatus::class,
    ];

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(User::class, 'delivery_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
