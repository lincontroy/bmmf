<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

interface ArticleRepositoryInterface extends BaseRepositoryInterface
{
    public function findArticle(string $slug, int $languageId): ?object;

    public function findPaginateArticle(array $attribute): ?object;

    public function findRelatedBlog(array $attribute): ?object;

    public function findArticleRow(string $slug, int $languageId): ?object;
    public function articleDetails(array $attribute): ?object;
    public function findArticleDetails(int $articleId, int $languageId): ?object;

    /**
     * Get header footer article
     *
     * @return object
     */
    public function getHeaderFooter(): object;

    /**
     * Header footer article menu
     *
     * @return Builder
     */
    public function headerFooterMenu(): Builder;

    /**
     * Home slider article
     *
     * @return Builder
     */
    public function homeSlider(): Builder;

    /**
     * Social Icon article
     *
     * @return Builder
     */
    public function socialIcon(): Builder;

    /**
     * Home about article
     *
     * @return Builder
     */
    public function homeAbout(): Builder;

    /**
     * Package Banner article
     *
     * @return Builder
     */
    public function packageBanner(): Builder;

    /**
     * Join Us Today article
     *
     * @return Builder
     */
    public function joinUsToday(): Builder;

    /**
     * Merchant title article
     *
     * @return Builder
     */
    public function merchantTitle(): Builder;

    /**
     * Bg Effect Image article
     *
     * @return Builder
     */
    public function bgEffectImg(): Builder;

    /**
     * Merchant top banner article
     *
     * @return Builder
     */
    public function merchantTopBanner(): Builder;

    /**
     * Merchant Content article
     *
     * @return Builder
     */
    public function merchantContent(): Builder;

    /**
     * Investment article
     *
     * @return Builder
     */
    public function investment(): Builder;

    /**
     * Quick Exchange Article
     *
     * @return Builder
     */
    public function quickExchange(): Builder;

    /**
     * Why Chose article
     *
     * @return Builder
     */
    public function whyChoseHeader(): Builder;

    /**
     * Why Chose Content article
     *
     * @return Builder
     */
    public function whyChoseContent(): Builder;

    /**
     * Satisfied customer header article
     *
     * @return Builder
     */
    public function satisfiedCustomerHeader(): Builder;

    /**
     * Customer satisfy content article
     *
     * @return Builder
     */
    public function customerSatisfyContent(): Builder;

    /**
     * Faq Header article
     *
     * @return Builder
     */
    public function faqHeader(): Builder;

    /**
     * Faq content article
     *
     * @return Builder
     */
    public function faqContent(): Builder;

    /**
     * Blog article
     *
     * @return Builder
     */
    public function blog(): Builder;

    /**
     * Blog Top Banner article
     *
     * @return Builder
     */
    public function blogTopBanner(): Builder;

    /**
     * Blog Details Top Banner article
     *
     * @return Builder
     */
    public function blogDetailsTopBanner(): Builder;

    /**
     * Contact us top banner article
     *
     * @return Builder
     */
    public function contactUsTopBanner(): Builder;

    /**
     * Contact address article
     *
     * @return Builder
     */
    public function contactAddress(): Builder;

    /**
     * Payment we accept article
     *
     * @return Builder
     */
    public function paymentWeAccept(): Builder;

    /**
     * Stake Banner article
     *
     * @return Builder
     */
    public function stakeBanner(): Builder;

    /**
     * B2X loan article
     *
     * @return Builder
     */
    public function b2xLoan(): Builder;

    /**
     * B2X loan banner article
     *
     * @return Builder
     */
    public function b2xLoanBanner(): Builder;

    /**
     * B2X calculator header article
     *
     * @return Builder
     */
    public function b2xCalculatorHeader(): Builder;

    /**
     * B2X loan details header article
     *
     * @return Builder
     */
    public function b2xLoanDetailsHeader(): Builder;

    /**
     * B2X loan details content article
     *
     * @return Builder
     */
    public function b2xLoanDetailsContent(): Builder;

    /**
     * Top investor top banner article
     *
     * @return Builder
     */
    public function topInvestorBanner(): Builder;

    /**
     * Top investor top banner article
     *
     * @return Builder
     */
    public function topInvestorTopBanner(): Builder;

    /**
     * Top investor header article
     *
     * @return Builder
     */
    public function topInvestorHeader(): Builder;

    /**
     * Our Service Header
     *
     * @return Builder
     */
    public function ourServiceHeader(): Builder;

    /**
     * Service Top Banner
     *
     * @return Builder
     */
    public function serviceTopBanner(): Builder;

    /**
     * Our Service
     *
     * @return Builder
     */
    public function ourService(): Builder;

    /**
     * Our Rate Header
     *
     * @return Builder
     */
    public function ourRateHeader(): Builder;

    /**
     * Our Rate
     *
     * @return Builder
     */
    public function ourRate(): Builder;

    /**
     * Team Member Banner
     *
     * @return Builder
     */
    public function teamMemberBanner(): Builder;

    /**
     * Team Header
     *
     * @return Builder
     */
    public function teamHeader(): Builder;

    /**
     * Our Difference Header
     *
     * @return Builder
     */
    public function ourDifferenceHeader(): Builder;

    /**
     * Our Difference Content
     *
     * @return Builder
     */
    public function ourDifferenceContent(): Builder;
}
