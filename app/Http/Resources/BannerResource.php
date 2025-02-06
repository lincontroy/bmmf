<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        foreach ($this->articleData as $articleData) {
            $data[$articleData->slug] = $articleData->content ?? null;
        }

        foreach ($this->articleLangData as $articleLangData) {
            $data[$articleLangData->slug] = $articleLangData->small_content ?? $articleLangData->large_content ?? null;
        }

        return $data;

    }
}
