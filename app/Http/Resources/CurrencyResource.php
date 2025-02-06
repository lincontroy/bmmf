<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        if (isset($this->currencyInfo->id)) {
            return [
                "id"     => $this->currencyInfo->id,
                "name"   => $this->currencyInfo->name,
                "symbol" => $this->currencyInfo->symbol,
            ];
        } else {
            return [
                "id"     => 0,
                "name"   => "",
                "symbol" => "",
            ];
        }

    }

}
