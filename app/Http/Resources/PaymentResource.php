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
            'tenant' => new TenantResource($this->whenLoaded('tenant')),
            'house_name' => $this->house->name,
            'building_name' => $this->house->building->name,
            'tenant_name' => $this->tenant->name,
            'amount' => $this->amount,
            'month' => $this->month->format('M-Y'),
            'date_paid' => $this->date_paid->format('d-M-Y'),
            'status' => $this->status,
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            'user' => new UserResource($this->whenLoaded('user')),
            'note' => $this->note,
            'reversed_on' => $this->status == 'reversed' ? $this->reversed_on->format('Y-m-d H:i:s') : '',
            'reversed_by' => $this->status == 'reversed' ? $this->reversedBy->name : '',
            'reverse_note' => $this->reverse_note ?: '',
        ];
    }
}
