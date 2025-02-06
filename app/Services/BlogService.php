<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Http\Resources\ArticleLangResource;
use App\Http\Resources\BlogDetailsResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\ManyArticlesResource;
use App\Repositories\Interfaces\ArticleRepositoryInterface;

class BlogService
{
    /**
     * BlogService constructor.
     *
     * @param ArticleRepositoryInterface $articleRepository
     */
    public function __construct(
        private ArticleRepositoryInterface $articleRepository,
    ) {
    }

    /**
     * Fetch data for blog paginate data
     * @param string $slug
     * @param int $languageId
     * @return mixed
     */
    public function findPaginateArticle(array $attribute): ?object
    {
        $articleData = $this->articleRepository->findPaginateBlog($attribute);
        return BlogResource::collection($articleData);
    }

    public function findLangArticle(string $slug, int $languageId): ?object
    {
        $articleData = $this->articleRepository->findDoubleWhereFirst('slug', $slug, 'status', StatusEnum::ACTIVE->value);

        if ($articleData) {
            $langData = $articleData->articleLangData->where('language_id', $languageId);

            if ($langData->isNotEmpty()) {
                return ArticleLangResource::collection($langData);
            }

        }

        return null;
    }

    /**
     * Fetch data for home slider
     * @param string $slug
     * @param int $languageId
     * @return mixed
     */
    public function findManyArticles(string $slug, int $languageId): ?object
    {
        $articleData = $this->articleRepository->findArticle($slug, $languageId);
        return ManyArticlesResource::collection($articleData);
    }

    public function findRelatedBlog(array $attribute): ?object
    {
        $articleData = $this->articleRepository->findRelatedBlog($attribute);
        return ManyArticlesResource::collection($articleData);
    }

    /**
     * Fetch data for blog details data
     * @param array $attribute
     * @return mixed
     */
    public function blogDetails(array $attribute): ?object
    {
        $articleData = $this->articleRepository->articleDetails($attribute);

        if ($articleData) {
            return new BlogDetailsResource($articleData);
        }

        return null;
    }

}
