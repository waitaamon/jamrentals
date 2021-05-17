<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HouseResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'building' => new BuildingResource($this->whenLoaded('building')),
            'tenant' => new TenantResource($this->whenLoaded('tenant')),
            'tenant_name' => (bool) $this->is_occupied ? $this->tenant->name : '',
            'building_name' => $this->building->name,
            'name' => $this->name,
            'rent' => $this->rent ?: '',
            'deposit' => $this->deposit ?: '',
            'note' => $this->note ?: '',
            'is_occupied' => (bool) $this->is_occupied,
            'payments' => PaymentResource::collection($this->whenLoaded('approvedPayments')),
            'payments_sum' => $this->approved_payments_sum_amount ?: 0,
            'unpaid_rent' => $this->approved_payments_sum_amount ?: 0,
            'created_at' => $this->created_at->format('d-M-Y')
        ];
    }
}
