<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'house' => new HouseResource($this->whenLoaded('house')),
            'house_name' => $this->house->name,
            'house_id' => $this->house->id,
            'name' => $this->name,
            'id_number' => $this->id_number ?: '',
            'phone' => $this->phone ?: '',
            'deposit' => $this->deposit,
            'incurred_cost' => $this->incurred_cost,
            'balance' => $this->balance,
            'note' => $this->note ?: '',
            'created_at' => $this->created_at->format('d-M-Y'),
            'invoice_from' => $this->invoice_from->format('Y-m-d'),
            'invoice_from_month' => $this->invoice_from->format('M-Y'),
            'invoices' => InvoiceResource::collection($this->whenLoaded('invoices')),
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
        ];
    }
}
