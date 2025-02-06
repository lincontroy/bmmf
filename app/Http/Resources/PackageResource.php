<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'package_id'    => $this->id,
            'package_name'  => $this->name,
            'invest_type'   => $this->invest_type,
            'min_price'     => $this->min_price,
            'max_price'     => $this->max_price,
            'interest_type' => $this->interest_type,
            'interest'      => $this->interest,
            'return_type'   => $this->return_type,
            'repeat_time'   => $this->repeat_time,
            'capital_back'  => $this->capital_back,
            'image'         => $this->image,
            'commission'    => $this->planTime->name_,
            'hours'         => $this->planTime->hours_,
        ];

        return $data;
    }
}
