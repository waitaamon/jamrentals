<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BuildingReportResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'payments' => PaymentResource::collection($this->payments),
            'unpaid_invoices' => InvoiceResource::collection($this->unpaid_invoices),
            'vacant_houses' => HouseResource::collection($this->vacant_houses),
            'deposits' => []
        ];
    }
}
