<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManyArticlesDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'article_id' => $this->id ?? 0,
        ];

        foreach ($this->articleData as $articleData) {
            $data[$articleData->slug] = $articleData->content ?? null;
        }

        foreach ($this->articleLangData as $articleLangData) {
            $data[$articleLangData->slug] = $articleLangData->small_content ?? $articleLangData->large_content ?? null;
        }

        return $data;
    }

}
