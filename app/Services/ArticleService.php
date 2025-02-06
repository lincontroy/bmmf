<?php

namespace App\Services;

use App\Repositories\Interfaces\ArticleRepositoryInterface;

class ArticleService
{
    /**
     * ArticleService constructor.
     *
     * @param ArticleRepositoryInterface $articleRepository
     */
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
    ) {
    }

    /**
     * CMS Menu form data
     *
     * @return array
     */
    public function cmsMenuFormData(): array
    {
        $headerFooterMenus = $this->articleRepository->getHeaderFooter();

        return compact('headerFooterMenus');
    }

    /**
     * Find article or throw 404
     *
     * @param  int  $id
     * @return object
     */
    public function findOrFail(int $id): object
    {
        return $this->articleRepository->findOrFail($id);
    }

    /**
     * First merchant title
     *
     * @return object
     */
    public function merchantTitle(): object
    {
        return $this->articleRepository->merchantTitle()->first();
    }

    /**
     * First merchant title
     *
     * @return object
     */
    public function merchantTopBanner(): object
    {
        return $this->articleRepository->merchantTopBanner()->first();
    }

    /**
     * First why chose header
     *
     * @return object
     */
    public function whyChoseHeader(): object
    {
        return $this->articleRepository->whyChoseHeader()->first();
    }

    /**
     * First why chose content
     *
     * @return object
     */
    public function bgEffectImg(): object
    {
        return $this->articleRepository->bgEffectImg()->first();
    }

    /**
     * First why chose content
     *
     * @return object
     */
    public function whyChoseContent(): object
    {
        return $this->articleRepository->whyChoseContent()->first();
    }

    /**
     * First satisfied customer header
     *
     * @return object
     */
    public function satisfiedCustomerHeader(): object
    {
        return $this->articleRepository->satisfiedCustomerHeader()->first();
    }

    /**
     * First faq header
     *
     * @return object
     */
    public function faqHeader(): object
    {
        return $this->articleRepository->faqHeader()->first();
    }

    /**
     * First Blog Top Banner
     *
     * @return object
     */
    public function blogTopBanner(): object
    {
        return $this->articleRepository->blogTopBanner()->first();
    }

    /**
     * First Blog Detail Top Banner
     *
     * @return object
     */
    public function blogDetailsTopBanner(): object
    {
        return $this->articleRepository->blogDetailsTopBanner()->first();
    }

    /**
     * First Contact us top banner
     *
     * @return object
     */
    public function contactUsTopBanner(): object
    {
        return $this->articleRepository->contactUsTopBanner()->first();
    }

    /**
     * First Payment we accept
     *
     * @return object
     */
    public function paymentWeAccept(): object
    {
        return $this->articleRepository->paymentWeAccept()->first();
    }

    /**
     * First Stake Banner
     *
     * @return object
     */
    public function stakeBanner(): object
    {
        return $this->articleRepository->stakeBanner()->first();
    }

    /**
     * First b2x Loan
     *
     * @return object
     */
    public function b2xLoan(): object
    {
        return $this->articleRepository->b2xLoan()->first();
    }

    /**
     * First b2x Loan Banner
     *
     * @return object
     */
    public function b2xLoanBanner(): object
    {
        return $this->articleRepository->b2xLoanBanner()->first();
    }

    /**
     * First b2x calculator header
     *
     * @return object
     */
    public function b2xCalculatorHeader(): object
    {
        return $this->articleRepository->b2xCalculatorHeader()->first();
    }

    /**
     * First b2x loan details header
     *
     * @return object
     */
    public function b2xLoanDetailsHeader(): object
    {
        return $this->articleRepository->b2xLoanDetailsHeader()->first();
    }

    /**
     * First b2x loan details content
     *
     * @return object
     */
    public function b2xLoanDetailsContent(): object
    {
        return $this->articleRepository->b2xLoanDetailsContent()->first();
    }

    /**
     * First Top investor banner
     *
     * @return object
     */
    public function topInvestorBanner(): object
    {
        return $this->articleRepository->topInvestorBanner()->first();
    }

    /**
     * First Top investor top banner
     *
     * @return object
     */
    public function topInvestorTopBanner(): object
    {
        return $this->articleRepository->topInvestorTopBanner()->first();
    }

    /**
     * First Top investor header
     *
     * @return object
     */
    public function topInvestorHeader(): object
    {
        return $this->articleRepository->topInvestorHeader()->first();
    }

    /**
     * First Our service header
     *
     * @return object
     */
    public function ourServiceHeader(): object
    {
        return $this->articleRepository->ourServiceHeader()->first();
    }

    /**
     * First Service Top Banner
     *
     * @return object
     */
    public function serviceTopBanner(): object
    {
        return $this->articleRepository->serviceTopBanner()->first();
    }

    /**
     * First Our rate header
     *
     * @return object
     */
    public function ourRateHeader(): object
    {
        return $this->articleRepository->ourRateHeader()->first();
    }

    /**
     * First Team Member Banner
     *
     * @return object
     */
    public function teamMemberBanner(): object
    {
        return $this->articleRepository->teamMemberBanner()->first();
    }

    /**
     * First Team Header
     *
     * @return object
     */
    public function teamHeader(): object
    {
        return $this->articleRepository->teamHeader()->first();
    }

    /**
     * First Our Difference Header
     *
     * @return object
     */
    public function ourDifferenceHeader(): object
    {
        return $this->articleRepository->ourDifferenceHeader()->first();
    }

    /**
     * First Our Difference Content
     *
     * @return object
     */
    public function ourDifferenceContent(): object
    {
        return $this->articleRepository->ourDifferenceContent()->first();
    }

}
