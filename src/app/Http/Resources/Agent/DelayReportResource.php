<?php

namespace App\Http\Resources\Agent;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DelayReportResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'order' => [
                'id' => $this->order->id,
                'name' => $this->order->name,
                'delivery_time' => $this->order->delivery_time,
                'estimate_delivered_at' => $this->order->estimate_delivered_at,
                'created_at' => $this->order->created_at->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
