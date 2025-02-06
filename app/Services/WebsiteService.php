<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Http\Resources\ArticleDataResource;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\FaqArticlesResource;
use App\Http\Resources\LanguageResource;
use App\Http\Resources\ManyArticlesResource;
use App\Http\Resources\PaymentGatewayResource;
use App\Http\Resources\SettingResource;
use App\Http\Resources\SocialIconResource;
use App\Http\Resources\TeamMemberResource;
use App\Http\Resources\TopInvestorResource;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use App\Repositories\Interfaces\PaymentGatewayRepositoryInterface;
use App\Repositories\Interfaces\SettingRepositoryInterface;
use App\Repositories\Interfaces\TeamMemberRepositoryInterface;
use App\Repositories\Interfaces\WalletManageRepositoryInterface;

class WebsiteService
{
    /**
     * WebsiteService constructor.
     *
     * @param ArticleRepositoryInterface $articleRepository
     * @param SettingRepositoryInterface $settingRepository
     * @param TeamMemberRepositoryInterface $settingRepository
     * @param WalletManageRepositoryInterface $walletManageRepository
     * @param PaymentGatewayRepositoryInterface $paymentGatewayRepository
     * @param LanguageRepositoryInterface $languageRepository
     */
    public function __construct(
        private ArticleRepositoryInterface $articleRepository,
        private SettingRepositoryInterface $settingRepository,
        private TeamMemberRepositoryInterface $teamMemberRepository,
        private WalletManageRepositoryInterface $walletManageRepository,
        private PaymentGatewayRepositoryInterface $paymentGatewayRepository,
        private LanguageRepositoryInterface $languageRepository,
    ) {
    }

    public function findLangArticles(string $slug, int $languageId): ?object
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
     * Fetch data for blog
     * @param string $slug
     * @param int $languageId
     * @return mixed
     */
    public function findBlogArticle(string $slug, int $languageId): ?object
    {
        $articleData = $this->articleRepository->findArticle($slug, $languageId);
        return BlogResource::collection($articleData);
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

    public function findPaginateArticle(array $attribute): ?object
    {
        $articleData = $this->articleRepository->findPaginateArticle($attribute);
        return ManyArticlesResource::collection($articleData);
    }

    public function findRelatedBlog(array $attribute): ?object
    {
        $articleData = $this->articleRepository->findRelatedBlog($attribute);
        return ManyArticlesResource::collection($articleData);
    }

    public function findFaqLangManyArticles(string $slug, int $languageId): ?object
    {
        $articleData = $this->articleRepository->findDoubleWhereFirst('slug', $slug, 'status', StatusEnum::ACTIVE->value);

        if ($articleData) {
            $langData = $articleData->articleLangData->where('language_id', $languageId);

            if ($langData->isNotEmpty()) {
                return FaqArticlesResource::collection($langData);
            }

        }

        return (object) [];
    }

    public function settingInfo(): ?object
    {
        $settingInfo = $this->settingRepository->find(1);

        if ($settingInfo) {
            return new SettingResource($settingInfo);
        }

        return (object) [];
    }

    public function findTeamMembers(int $pageNo): ?object
    {
        $teamMembers = $this->teamMemberRepository->orderPaginate([
            "orderByColumn"     => "id",
            "order"             => "asc",
            "searchColumn"      => "status",
            "searchColumnValue" => StatusEnum::ACTIVE->value,
            "perPage"           => 15,
            "page"              => $pageNo,
        ], ['memberSocials']);

        if ($teamMembers) {
            return TeamMemberResource::collection($teamMembers);
        }

        return (object) [];
    }

    public function findTopInvestors(): ?object
    {
        $topInvestors = $this->walletManageRepository->topInvestors();

        if ($topInvestors) {
            return TopInvestorResource::collection($topInvestors);
        }

        return (object) [];
    }

    public function gatewayList(): ?object
    {
        $gateways = $this->paymentGatewayRepository->findAll();

        if ($gateways) {
            return PaymentGatewayResource::collection($gateways);
        }

        return (object) [];
    }

    public function blogDetails(array $attribute): ?object
    {
        $articleData = $this->articleRepository->find($attribute['article_id']);

        if ($articleData) {
            $langData = $articleData->articleLangData->where('language_id', $attribute['language_id']);

            if ($langData->isNotEmpty()) {
                return (object)
                    [
                    'blog_img'    => ArticleDataResource::collection($articleData->articleData),
                    'blog_conten' => ArticleResource::collection($langData),
                ];
            }

        }

        return null;
    }

    public function findSocialIcon($slug): ?object
    {
        $socialIcons = $this->articleRepository->findWhere('slug', $slug);

        if ($socialIcons) {
            return SocialIconResource::collection($socialIcons);
        }

        return (object) [];
    }

    public function languages(): ?object
    {
        $languages = $this->languageRepository->all();

        if ($languages) {
            return LanguageResource::collection($languages);
        }

        return (object) [];
    }

}
