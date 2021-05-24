<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'house' => new HouseResource($this->whenLoaded('house')),
            'tenant' => new TenantResource($this->whenLoaded('tenant')),
            'building_name' => $this->house->building->name,
            'house_name' => $this->house->name,
            'tenant_name' => $this->tenant->name,
            'amount' => $this->amount,
            'paid' => $this->paid,
            'balance' => $this->balance,
            'month' => $this->month->format('M-Y'),
            'status' => $this->status,
            'created_at' => $this->created_at->format('d-M-Y')
        ];
    }
}
