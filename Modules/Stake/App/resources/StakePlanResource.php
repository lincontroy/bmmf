<?php

namespace Modules\Stake\App\resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StakePlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $data = [
            'currency_logo' => $this->acceptCurrency->logo ?? null,
            'stake_name'    => $this->stake_name ?? null,
            'image'         => $this->image ?? 'upload/stake/stake-a.e82f9f17.png',
        ];

        $rateData = [];

        foreach ($this->stakeRateInfo as $rateInfo) {
            $rateData[] = [
                'duration'    => $rateInfo->duration ?? 0,
                'annual_rate' => $rateInfo->annual_rate ?? 0,
                'min_price'   => $rateInfo->min_amount ?? 0,
                'max_price'   => $rateInfo->max_amount ?? 0,
            ];
        }

        $data['rateInfo'] = $rateData;

        return $data;
    }

}
