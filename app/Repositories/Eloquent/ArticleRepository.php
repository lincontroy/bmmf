<?php

namespace App\Repositories\Eloquent;

use App\Enums\ArticleTypeEnum;
use App\Enums\StatusEnum;
use App\Models\Article;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class ArticleRepository extends BaseRepository implements ArticleRepositoryInterface
{
    public function __construct(Article $model)
    {
        parent::__construct($model);
    }

    /**
     * Base query
     *
     * @param  array  $attributes
     * @return Builder
     */
    private function baseQuery(array $attributes = []): Builder
    {
        $query = $this->model->newQuery();

        if (isset($attributes['slug'])) {
            $query = $query->where('slug', $attributes['slug']);
        }

        if (isset($attributes['article_name'])) {
            $query = $query->where('article_name', $attributes['article_name']);
        }

        if (isset($attributes['status'])) {
            $query = $query->where('status', $attributes['status']);
        }

        return $query;
    }

    /**
     * Fillable data
     *
     * @param  array  $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        $data = [];

        if (isset($attributes['slug'])) {
            $data['slug'] = $attributes['slug'];
        }

        if (isset($attributes['article_name'])) {
            $data['article_name'] = $attributes['article_name'];
        }

        if (isset($attributes['status'])) {
            $data['status'] = $attributes['status'];
        }

        return $data;

    }

    /**
     * @inheritDoc
     */
    public function all(array $attributes = []): ?object
    {
        return $this->baseQuery($attributes)->get();
    }

    /**
     * @inheritDoc
     */
    public function first(array $attributes = []): ?object
    {
        return $this->baseQuery($attributes)->first();
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        $data = $this->fillable($attributes);

        if (!isset($data['status'])) {
            $data['status'] = StatusEnum::ACTIVE->value;
        }

        return parent::create($data);
    }

    /**
     * @inheritDoc
     */
    public function updateById(int $id, array $attributes): bool
    {
        $data = $this->fillable($attributes);

        return parent::updateById($id, $data);
    }

    public function findArticle(string $slug, int $languageId): ?object
    {
        return $this->model->where("slug", $slug)->where("status", StatusEnum::ACTIVE->value)
            ->with('articleLangData', function ($query) use ($languageId) {
                $query->where('language_id', $languageId);
            })->get();
    }

    public function findArticleDetails(int $articleId, int $languageId): ?object
    {
        return $this->model->where("id", $articleId)->where("status", StatusEnum::ACTIVE->value)
            ->with('articleLangData', function ($query) use ($languageId) {
                $query->where('language_id', $languageId);
            })->first();
    }

    public function findArticleRow(string $slug, int $languageId): ?object
    {
        return $this->model->where("slug", $slug)->where("status", StatusEnum::ACTIVE->value)
            ->with('articleLangData', function ($query) use ($languageId) {
                $query->where('language_id', $languageId);
            })->first();
    }

    public function articleDetails(array $attribute): ?object
    {
        $articleId  = $attribute['article_id'];
        $languageId = $attribute['language_id'];

        return $this->model->where("id", $articleId)
            ->where("status", StatusEnum::ACTIVE->value)
            ->with('articleLangData', function ($query) use ($languageId, $articleId) {
                $query->where('language_id', $languageId);

// ->where('article_id', $articleId)->with('creatorInfo')
                // ->first();
            })
            ->first();

    }

    public function findPaginateArticle(array $attribute): ?object
    {
        $articleData = $this->model->where("slug", $attribute['slug'])
            ->where("status", StatusEnum::ACTIVE->value)
            ->paginate($attribute['perPage']);
        $articleData->load(['articleLangData' => function ($query) use ($attribute) {
            $query->where('language_id', $attribute['language_id']);
        },
        ]);

        return $articleData;
    }

    public function findPaginateBlog(array $attribute): ?object
    {
        $articleData = $this->model->where("slug", $attribute['slug'])
            ->where("status", StatusEnum::ACTIVE->value)
            ->orderBy('id', 'desc')
            ->paginate($attribute['perPage'], ['*'], 'page', $attribute['page']);

        $articleData->load(['articleLangData' => function ($query) use ($attribute) {
            $query->where('language_id', $attribute['language_id']);
        },
        ]);

        return $articleData;
    }

    public function findRelatedBlog(array $attribute): ?object
    {
        $articleData = $this->model->where("slug", $attribute['slug'])->where("id", '!=', $attribute['article_id'])
            ->where("status", StatusEnum::ACTIVE->value)
            ->paginate(6);
        $articleData->load(['articleLangData' => function ($query) use ($attribute) {
            $query->where('language_id', $attribute['language_id']);
        },
        ]);

        return $articleData;
    }

    /**
     * @inheritDoc
     */
    public function getHeaderFooter(): object
    {
        return $this->model->whereIn('slug', [ArticleTypeEnum::HEADER_MENU->value, ArticleTypeEnum::FOOTER_MENU->value])->orderBy('article_name', 'desc')->get();
    }

    /**
     * @inheritDoc
     */
    public function headerFooterMenu(): Builder
    {
        return $this->model->whereIn('slug', [ArticleTypeEnum::HEADER_MENU->value, ArticleTypeEnum::FOOTER_MENU->value])->orderBy('article_name', 'desc');
    }

    /**
     * @inheritDoc
     */
    public function bgEffectImg(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::BG_EFFECT_IMG->value)->with('articleData')->orderBy('article_name', 'desc');
    }

    /**
     * @inheritDoc
     */
    public function homeSlider(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::HOME_SLIDER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function socialIcon(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::SOCIAL_ICON->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function homeAbout(): Builder
    {
        return $this->model->whereIn('slug', [ArticleTypeEnum::HOME_ABOUT->value, ArticleTypeEnum::ABOUT_US_BANNER->value])->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function packageBanner(): Builder
    {
        return $this->model->whereIn('slug', [ArticleTypeEnum::PACKAGE_BANNER->value, ArticleTypeEnum::PACKAGE_HEADER->value])->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function joinUsToday(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::JOIN_US_TODAY->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function merchantTitle(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::MERCHANT_TITLE->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function merchantTopBanner(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::MERCHANT_TOP_BANNER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function merchantContent(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::MERCHANT_CONTENT->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function investment(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::INVESTMENT_HEADER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function quickExchange(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::QUICK_EXCHANGE->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function whyChoseHeader(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::WHY_CHOSE_HEADER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function whyChoseContent(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::WHY_CHOSE_CONTENT->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function satisfiedCustomerHeader(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::SATISFIED_CUSTOMER_HEADER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function customerSatisfyContent(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::CUSTOMER_SATISFY_CONTENT->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function faqHeader(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::FAQ_HEADER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function faqContent(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::FAQ_CONTENT->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function blog(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::Blog->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function blogTopBanner(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::Blog_TOP_BANNER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function blogDetailsTopBanner(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::Blog_DETAILS_TOP_BANNER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function contactUsTopBanner(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::CONTACT_US_TOP_BANNER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function contactAddress(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::CONTACT_ADDRESS->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function paymentWeAccept(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::PAYMENT_WE_ACCEPT_HEADER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function stakeBanner(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::STAKE_BANNER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function b2xLoan(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::B2X_LOAN->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function b2xLoanBanner(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::B2X_LOAN_BANNER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function b2xCalculatorHeader(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::b2x_CALCULATOR_HEADER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function b2xLoanDetailsHeader(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::B2X_LOAN_DETAILS_HEADER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function b2xLoanDetailsContent(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::B2X_LOAN_DETAILS_CONTENT->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function topInvestorBanner(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::TOP_INVESTOR_BANNER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function topInvestorTopBanner(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::TOP_INVESTOR_TOP_BANNER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function topInvestorHeader(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::TOP_INVESTOR_HEADER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function ourServiceHeader(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::OUR_SERVICE_HEADER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function serviceTopBanner(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::SERVICE_TOP_BANNER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function ourService(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::OUR_SERVICE->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function ourRateHeader(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::OUR_RATES_HEADER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function ourRate(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::OUR_RATE_CONTENT->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function teamMemberBanner(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::TEAM_MEMBER_BANNER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function teamHeader(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::TEAM_HEADER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function ourDifferenceHeader(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::OUR_DIFFERENCE_HEADER->value)->with('articleData');
    }

    /**
     * @inheritDoc
     */
    public function ourDifferenceContent(): Builder
    {
        return $this->model->where('slug', ArticleTypeEnum::OUR_DIFFERENCE_CONTENT->value)->with('articleData');
    }

}
