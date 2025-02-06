<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Http\Resources\ArticleDataResource;
use App\Http\Resources\ArticleLangResource;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\FaqArticlesResource;
use App\Http\Resources\ManyArticlesDetailsResource;
use App\Http\Resources\ManyArticlesResource;
use App\Http\Resources\PaymentGatewayResource;
use App\Http\Resources\SocialIconResource;
use App\Http\Resources\TopInvestorResource;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\PaymentGatewayRepositoryInterface;
use App\Repositories\Interfaces\WalletManageRepositoryInterface;

class HomeService
{
    /**
     * HomeService constructor.
     *
     */
    public function __construct(
        private ArticleRepositoryInterface $articleRepository,
        private PaymentGatewayRepositoryInterface $gatewayRepository,
        private WalletManageRepositoryInterface $walletManageRepository,
    ) {
    }

    public function findTopHeaderMenu(string $slug, int $languageId): ?object
    {
        $articleData = $this->articleRepository->findDoubleWhereFirst('slug', $slug, 'status', StatusEnum::ACTIVE->value);

        if ($articleData) {
            $langData = $articleData->articleLangData->where('language_id', $languageId);

            if ($langData->isNotEmpty()) {
                return ArticleResource::collection($langData);
            }

        }

        return (object) [];
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

    /**
     * Fetch data for home slider
     * @param string $slug
     * @param int $languageId
     * @return mixed
     */
    public function findManyArticlesDetails(int $articleId, int $languageId): ?object
    {
        $articleData = $this->articleRepository->findArticleDetails($articleId, $languageId);
        return new ManyArticlesDetailsResource($articleData);
    }

    /**
     * Fetch data for home slider
     * @param string $slug
     * @param int $languageId
     * @return mixed
     */
    public function findFaqArticles(string $slug, int $languageId): ?object
    {
        $articleData = $this->articleRepository->findArticle($slug, $languageId);
        return FaqArticlesResource::collection($articleData);
    }

    /**
     * Find Language Article
     * @param string $slug
     * @param int $languageId
     * @return object|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
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
     * Find Article And Data
     * @param string $slug
     * @return object|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function findArticleData(string $slug): ?object
    {
        $articleData = $this->articleRepository->findDoubleWhere('slug', $slug, 'status', StatusEnum::ACTIVE->value);

        if ($articleData) {
            return SocialIconResource::collection($articleData);
        }

        return null;
    }

    /**
     * Find all gatewayList
     * @return object|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function gatewayList(): ?object
    {
        $gateways = $this->gatewayRepository->findAll();

        if ($gateways) {
            return PaymentGatewayResource::collection($gateways);
        }

        return (object) [];
    }

    /**
     * Find lang many articles
     *
     * @param string $slug
     * @param integer $languageId
     * @return object|null
     */
    public function findLangManyArticles(string $slug, int $languageId): ?object
    {
        $articleData = $this->articleRepository->findArticle($slug, $languageId);
        return ManyArticlesResource::collection($articleData);
    }

    /**
     * Find blog details data
     * @param array $attribute
     * @return object|null
     */
    public function blogDetails(array $attribute): ?object
    {
        $articleData = $this->articleRepository->find($attribute['article_id']);

        if ($articleData) {
            $langData = $articleData->articleLangData->where('language_id', $attribute['language_id']);

            if ($langData->isNotEmpty()) {
                return (object)
                    [
                    'blog_img'     => ArticleDataResource::collection($articleData->articleData),
                    'blog_content' => ArticleResource::collection($langData),
                ];
            }

        }

        return null;
    }

    /**
     * Find top investors data by paginate
     * @param int $pageNo
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|null
     */
    public function findTopInvestors(int $pageNo): ?object
    {
        $topInvestors = $this->walletManageRepository->orderPaginate([
            "orderByColumn" => "investment",
            "order"         => "desc",
            "perPage"       => 25,
            "page"          => $pageNo,
        ], ['customerInfo']);

        if ($topInvestors) {
            return TopInvestorResource::collection($topInvestors);
        }

        return null;
    }

}
