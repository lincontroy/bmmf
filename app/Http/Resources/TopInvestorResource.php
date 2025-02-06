<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopInvestorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'investment' => $this->investment ?? 0,
            'customerInfo' => new CustomerResource($this->customerInfo)
        ];

        return $data;
    }
}
