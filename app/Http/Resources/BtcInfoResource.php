<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BtcInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'name'   => $this->name ?? null,
            'symbol' => $this->symbol ?? null,
            'price'  => $this->b2xCurrency->price ?? null,
        ];
        return $data;
    }
}