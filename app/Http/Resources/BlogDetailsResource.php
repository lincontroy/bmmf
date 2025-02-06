<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'article_id'   => $this->id ?? 0,
            'date'         => $this->created_at ?? null,
            'image'        => $this->getImage() ?? null,
            'blog_title'   => $this->blogTitle() ?? null,
            'blog_content' => $this->blogContent() ?? null,
            'creator_info' => new CreatorInfoResource($this->articleLangData[0]->creatorInfo),
        ];
    }

    private function getImage(): ?string
    {
        return $this->articleData->where('slug', 'image')->first()?->content;
    }
    private function blogTitle(): ?string
    {
        return $this->articleLangData->where('slug', 'blog_title')->first()?->small_content;
    }

    private function blogContent(): ?string
    {
        return $this->articleLangData->where('slug', 'blog_content')->first()?->large_content;
    }
}
