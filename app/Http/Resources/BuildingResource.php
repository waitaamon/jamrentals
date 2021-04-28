<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BuildingResource extends JsonResource
{
    public function toArray($request): array
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location ?: '',
            'default_rent' => $this->default_rent ?: '',
            'default_deposit'=>  $this->default_deposit ?: '',
            'attributes' => $this->attributes,
            'created_at' => $this->created_at->format('d-M-Y'),
            'houses_count' => $this->houses_count,
            'houses' => HouseResource::collection($this->whenLoaded('houses'))
        ];
    }
}
