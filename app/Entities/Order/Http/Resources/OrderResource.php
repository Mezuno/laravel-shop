<?php

namespace App\Entities\Order\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'total_price' => $this->total_price,
            'payment_status' => $this->payment_status,
            'payment_status_string' => $this->paymentStatusString,
            'order_status' => $this->status,
            'order_status_string' => $this->orderStatusString,
            'products' => json_decode($this->products),
            'address' => $this->address,
        ];
    }
}
