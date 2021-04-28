<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'house' => new HouseResource($this->whenLoaded('house')),
            'house_name' => $this->house->name,
            'tenant' => $this->tenant,
            'amount' => $this->amount,
            'is_deposit' => (bool)$this->is_deposit,
            'month' => $this->month->format('M-Y'),
            'date_paid' => $this->month->format('d-M-Y'),
            'status' => $this->status,
            'created_at' => $this->created_at->format('d-m-Y H:i:s')
        ];
    }
}
