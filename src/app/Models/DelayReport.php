<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DelayReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'agent_id',
        'checked_at',
    ];

    protected $hidden = [
        'unique_order_id_agent_id_checked_at_md5'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }
}
