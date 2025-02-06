<?php

namespace Modules\B2xloan\App\Http\Resources;

use App\Enums\NumberEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class B2xPackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id'               => $this->id ?? null,
            'no_of_month'      => $this->no_of_month ?? null,
            'interest_percent' => number_format($this->interest_percent, NumberEnum::MIN_DECIMAL->value, '.', '') ?? null,
        ];
        return $data;
    }
}
