<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqArticlesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        foreach ($this->articleLangData as $articleLangData) {
            $data['slug']     = $articleLangData->slug ?? null;
            $data['question'] = $articleLangData->small_content ?? null;
            $data['answer']   = $articleLangData->large_content ?? null;
        }

        return $data;
    }

}