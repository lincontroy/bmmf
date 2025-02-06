<?php

namespace Modules\CMS\App\Services;

use App\Enums\ArticleDataTypeEnum;
use App\Enums\ArticleLangDataTypeEnum;
use App\Helpers\ImageHelper;
use App\Repositories\Interfaces\ArticleDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleLangDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class CMSB2XLoanService
{
    /**
     * CMSB2XLoanService constructor.
     *
     */
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
        protected ArticleDataRepositoryInterface $articleDataRepository,
        protected ArticleLangDataRepositoryInterface $articleLangDataRepository,
    ) {
    }

    /**
     * Update CMS b2x loan
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $articleId = $attributes['article_id'];

        try {
            DB::beginTransaction();

            $articleUpdateData = [
                'article_name' => $attributes['b2x_loan'],
                'status'       => $attributes['loan_status'],
            ];

            $articleUpdateCheck = $this->articleRepository->updateById($articleId, $articleUpdateData);

            if ($articleUpdateCheck) {
                /**
                 * Article Data insert start
                 */
                $articleDataInsertData = [
                    [
                        'article_id' => $articleId,
                        'slug'       => ArticleDataTypeEnum::IMAGE->value,
                    ],
                ];

                foreach ($articleDataInsertData as $data) {
                    $articleData = $this->articleDataRepository->first(['article_id' => $articleId, 'slug' => $data['slug']]);

                    if ($articleData) {

                        if ($data['slug'] != ArticleDataTypeEnum::IMAGE->value) {
                            $this->articleDataRepository->updateByCondition(['article_id' => $articleId, 'slug' => $data['slug']], $data);
                        } elseif ($data['slug'] == ArticleDataTypeEnum::IMAGE->value) {

                            if (isset($attributes['loan_image'])) {
                                $data['content'] = ImageHelper::upload($attributes['loan_image'] ?? null, 'b2x', $articleData['content']);
                                $this->articleDataRepository->updateByCondition(['article_id' => $articleId, 'slug' => $data['slug']], $data);
                            }

                        }

                    } else {

                        if (isset($data['content'])) {
                            $this->articleDataRepository->create($data);
                        } elseif (isset($attributes['loan_image'])) {
                            $data['content'] = ImageHelper::upload($attributes['loan_image'] ?? null, 'b2x');
                            $this->articleDataRepository->create($data);
                        }

                    }

                }

                /**
                 * Article Data insert end
                 */

                /**
                 * Article Lang Data insert start
                 */
                $articleLangDataInsertData = [
                    [
                        'article_id'    => $articleId,
                        'language_id'   => $attributes['loan_language_id'],
                        'slug'          => ArticleLangDataTypeEnum::B2X_TITLE->value,
                        'small_content' => $attributes['b2x_title'],
                    ],
                    [
                        'article_id'    => $articleId,
                        'language_id'   => $attributes['loan_language_id'],
                        'slug'          => ArticleLangDataTypeEnum::B2X_BUTTON_ONE_TEXT->value,
                        'small_content' => $attributes['b2x_button_one_text'],
                    ],
                    [
                        'article_id'    => $articleId,
                        'language_id'   => $attributes['loan_language_id'],
                        'slug'          => ArticleLangDataTypeEnum::B2X_BUTTON_TWO_TEXT->value,
                        'small_content' => $attributes['b2x_button_two_text'],
                    ],
                    [
                        'article_id'    => $articleId,
                        'language_id'   => $attributes['loan_language_id'],
                        'slug'          => ArticleLangDataTypeEnum::B2X_CONTENT->value,
                        'large_content' => $attributes['b2x_content'],
                    ],
                ];

                foreach ($articleLangDataInsertData as $data) {
                    $articleLangData = $this->articleLangDataRepository->first(['article_id' => $articleId, 'slug' => $data['slug'], 'language_id' => $data['language_id']]);

                    if ($articleLangData) {
                        $this->articleLangDataRepository->updateById($articleLangData->id, $data);
                    } else {
                        $this->articleLangDataRepository->create($data);
                    }

                }

                /**
                 * Article Lang Data insert end
                 */
            }

            DB::commit();

            return true;

        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("B2X Loan update error"),
                'title'   => localize('B2X Loan'),
                'errors'  => $exception,
            ], 422));
        }

    }

}
