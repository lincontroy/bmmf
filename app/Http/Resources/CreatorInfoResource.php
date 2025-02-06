<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreatorInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'first_name'    => $this->first_name ?? null,
            'last_name'     => $this->last_name ?? null,
            'about'         => $this->about ?? null,
            'email'         => $this->email ?? null,
            'image'         => $this->image ?? null,
            'creation_date' => $this->created_at ?? null,
        ];
    }
}
