<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialIconResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'name' => $this->article_name ?? null,
        ];

        foreach ($this->articleData as $articleData) {
            $data[$articleData->slug] = $articleData->content ?? null;
        }

        return $data;
    }
}