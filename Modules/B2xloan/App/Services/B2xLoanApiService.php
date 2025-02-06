<?php

namespace Modules\B2xloan\App\Services;

use App\Enums\NumberEnum;
use App\Enums\StatusEnum;
use App\Http\Resources\ArticleDataResource;
use App\Http\Resources\ArticleLangResource;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\BtcInfoResource;
use App\Http\Resources\FaqArticlesResource;
use App\Http\Resources\ManyArticlesDetailsResource;
use App\Http\Resources\ManyArticlesResource;
use App\Http\Resources\PaymentGatewayResource;
use App\Http\Resources\SocialIconResource;
use App\Http\Resources\TopInvestorResource;
use App\Repositories\Interfaces\AcceptCurrencyRepositoryInterface;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\PaymentGatewayRepositoryInterface;
use App\Repositories\Interfaces\WalletManageRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\B2xloan\App\Http\Resources\B2xPackageResource;
use Modules\B2xloan\App\Repositories\Interfaces\B2xCurrencyRepositoryInterface;
use Modules\B2xloan\App\Repositories\Interfaces\PackageRepositoryInterface;

class B2xLoanApiService
{
    /**
     * B2xLoanApiService constructor.
     *
     */
    public function __construct(
        private ArticleRepositoryInterface $articleRepository,
        private PaymentGatewayRepositoryInterface $gatewayRepository,
        private WalletManageRepositoryInterface $walletManageRepository,
        private AcceptCurrencyRepositoryInterface $acceptedCurrencyRepository,
        private PackageRepositoryInterface $packageRepository,
        private B2xCurrencyRepositoryInterface $b2xCurrencyRepository,
    ) {
    }

    public function findTopHeaderMenu(string $slug, int $languageId): ?object
    {
        $articleData = $this->articleRepository->findDoubleWhereFirst(
            'slug',
            $slug,
            'status',
            StatusEnum::ACTIVE->value
        );

        if ($articleData) {
            $langData = $articleData->articleLangData->where('language_id', $languageId);

            if ($langData->isNotEmpty()) {
                return ArticleResource::collection($langData);
            }
        }

        return (object)[];
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
     * @return object|AnonymousResourceCollection
     */
    public function findLangArticle(string $slug, int $languageId): ?object
    {
        $articleData = $this->articleRepository->findDoubleWhereFirst(
            'slug',
            $slug,
            'status',
            StatusEnum::ACTIVE->value
        );

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
     * @return object|AnonymousResourceCollection
     */
    public function findArticleData(string $slug): ?object
    {
        $articleData = $this->articleRepository->findDoubleWhere('slug', $slug, 'status', StatusEnum::ACTIVE->value);

        if ($articleData) {
            return SocialIconResource::collection($articleData);
        }

        return null;
    }

    public function gatewayList(): ?object
    {
        $gateways = $this->gatewayRepository->findAll();

        if ($gateways) {
            return PaymentGatewayResource::collection($gateways);
        }

        return (object)[];
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

    public function findTopInvestors(): ?object
    {
        $topInvestors = $this->walletManageRepository->topInvestors();

        if ($topInvestors) {
            return TopInvestorResource::collection($topInvestors);
        }

        return null;
    }

    /**
     * get data by id
     * @param mixed $id
     * @return object
     */
    public function findData(): ?object
    {
        $btcRate = $this->acceptedCurrencyRepository->firstWhere('symbol', 'BTC');

        if ($btcRate) {
            $btcInfo = new BtcInfoResource($btcRate);

            return $btcInfo;
        }

        return null;
    }

    public function packages(): ?object
    {
        $packages    = $this->packageRepository->activeALl();
        $packagesRes = B2xPackageResource::collection($packages);

        return (object)$packagesRes;
    }

    public function b2xLoanCalculator(array $attributes): ?object
    {
        $month         = $attributes['package_month'];
        $holdingAmount = $attributes['holding_amount'];
        $btcRate       = $this->acceptedCurrencyRepository->firstWhere('symbol', 'BTC');
        $feeInfo       = $this->packageRepository->firstWhere('no_of_month', $month);
        $price         = $btcRate->rate ?? 0;

        $result = (object)[];

        if ($btcRate && $feeInfo) {
            $interestRate    = number_format($feeInfo->interest_percent, NumberEnum::MIN_DECIMAL->value, '.', '');
            $loanAmount      = number_format(($holdingAmount * $price) / 2, NumberEnum::MIN_DECIMAL->value, '.', '');
            $interestAmount  = number_format(
                ($loanAmount * $interestRate) / 100,
                NumberEnum::MIN_DECIMAL->value,
                '.',
                ''
            );
            $totalLoanAmount = number_format($loanAmount + $interestAmount, NumberEnum::MIN_DECIMAL->value, '.', '');
            $repayAmount     = number_format(
                $totalLoanAmount / $feeInfo->no_of_month,
                NumberEnum::MIN_DECIMAL->value,
                '.',
                ''
            );

            $result = (object)[$loanAmount, $repayAmount, $interestRate, $totalLoanAmount];
        }

        return $result;
    }

}
