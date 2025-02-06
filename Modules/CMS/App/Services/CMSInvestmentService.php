<?php

namespace Modules\CMS\App\Services;

use App\Enums\ArticleDataTypeEnum;
use App\Enums\ArticleLangDataTypeEnum;
use App\Enums\ArticleTypeEnum;
use App\Helpers\ImageHelper;
use App\Repositories\Interfaces\ArticleDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleLangDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class CMSInvestmentService
{
    /**
     * CMSInvestmentService constructor.
     *
     */
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
        protected ArticleDataRepositoryInterface $articleDataRepository,
        protected ArticleLangDataRepositoryInterface $articleLangDataRepository,
    ) {
    }

    /**
     * Create CMS Investment
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function create(array $attributes): bool
    {
        try {
            DB::beginTransaction();
            $articleInsertData = [
                'slug'         => ArticleTypeEnum::HOME_ABOUT->value,
                'article_name' => $attributes['about_name'],
                'status'       => $attributes['status'],
            ];
            $article = $this->articleRepository->create($articleInsertData);

            if ($article) {
                /**
                 * Article Data insert start
                 */
                $articleDataInsertData = [
                    [
                        'article_id' => $article->id,
                        'slug'       => ArticleDataTypeEnum::IMAGE->value,
                        'content'    => ImageHelper::upload($attributes['image'] ?? null, 'investment'),
                    ],
                    [
                        'article_id' => $article->id,
                        'slug'       => ArticleDataTypeEnum::URL->value,
                        'content'    => $attributes['button_link'],
                    ],
                ];

                foreach ($articleDataInsertData as $data) {
                    $this->articleDataRepository->create($data);
                }

                /**
                 * Article Data insert end
                 */

                /**
                 * Article Lang Data insert start
                 */
                $articleLangDataInsertData = [
                    [
                        'article_id'    => $article->id,
                        'language_id'   => $attributes['language_id'],
                        'slug'          => ArticleLangDataTypeEnum::ABOUT_TITLE->value,
                        'small_content' => $attributes['about_title'],
                    ],
                    [
                        'article_id'    => $article->id,
                        'language_id'   => $attributes['language_id'],
                        'slug'          => ArticleLangDataTypeEnum::ABOUT_HEADER->value,
                        'small_content' => $attributes['about_header'],
                    ],
                    [
                        'article_id'    => $article->id,
                        'language_id'   => $attributes['language_id'],
                        'slug'          => ArticleLangDataTypeEnum::ABOUT_CONTENT->value,
                        'large_content' => $attributes['about_paragraph'],
                    ],
                    [
                        'article_id'    => $article->id,
                        'language_id'   => $attributes['language_id'],
                        'slug'          => ArticleLangDataTypeEnum::ABOUT_BUTTON_TEXT->value,
                        'small_content' => $attributes['about_button_text'],
                    ],
                ];

                foreach ($articleLangDataInsertData as $data) {
                    $this->articleLangDataRepository->create($data);
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
                'message' => localize("Investment create error"),
                'title'   => localize('Investment'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update CMS Investment
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
                'slug'         => ArticleTypeEnum::INVESTMENT_HEADER->value,
                'article_name' => $attributes['investment_name'],
                'status'       => $attributes['status'],
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
                    [
                        'article_id' => $articleId,
                        'slug'       => ArticleDataTypeEnum::URL->value,
                        'content'    => $attributes['button_link'],
                    ],
                ];

                foreach ($articleDataInsertData as $data) {
                    $articleData = $this->articleDataRepository->first(['article_id' => $articleId, 'slug' => $data['slug']]);

                    if ($articleData) {

                        if ($data['slug'] != ArticleDataTypeEnum::IMAGE->value) {
                            $this->articleDataRepository->updateByCondition(['article_id' => $articleId, 'slug' => $data['slug']], $data);
                        } elseif ($data['slug'] == ArticleDataTypeEnum::IMAGE->value) {

                            if (isset($attributes['image'])) {
                                $data['content'] = ImageHelper::upload($attributes['image'] ?? null, 'investment', $articleData['content']);
                                $this->articleDataRepository->updateByCondition(['article_id' => $articleId, 'slug' => $data['slug']], $data);
                            }

                        }

                    } else {

                        if (isset($data['content'])) {
                            $this->articleDataRepository->create($data);
                        } elseif (isset($attributes['image'])) {
                            $data['content'] = ImageHelper::upload($attributes['image'] ?? null, 'investment');
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
                        'language_id'   => $attributes['language_id'],
                        'slug'          => ArticleLangDataTypeEnum::INVESTMENT_HEADER_TITLE->value,
                        'small_content' => $attributes['investment_header_title'],
                    ],
                    [
                        'article_id'    => $articleId,
                        'language_id'   => $attributes['language_id'],
                        'slug'          => ArticleLangDataTypeEnum::INVESTMENT_HEADER_CONTENT->value,
                        'large_content' => $attributes['investment_header_content'],
                    ],
                    [
                        'article_id'    => $articleId,
                        'language_id'   => $attributes['language_id'],
                        'slug'          => ArticleLangDataTypeEnum::INVESTMENT_BUTTON_TEXT->value,
                        'small_content' => $attributes['investment_button_text'],
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
                'message' => localize("Investment update error"),
                'title'   => localize('Investment'),
                'errors'  => $exception,
            ], 422));
        }

    }

}
