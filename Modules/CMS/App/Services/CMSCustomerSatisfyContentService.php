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

class CMSCustomerSatisfyContentService
{
    /**
     * CMSCustomerSatisfyContentService constructor.
     *
     */
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
        protected ArticleDataRepositoryInterface $articleDataRepository,
        protected ArticleLangDataRepositoryInterface $articleLangDataRepository,
    ) {
    }

    /**
     * Create CMS customer satisfy content
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
                'slug'         => ArticleTypeEnum::CUSTOMER_SATISFY_CONTENT->value,
                'article_name' => $attributes['customer_satisfy_content'],
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
                        'slug'       => ArticleDataTypeEnum::URL->value,
                        'content'    => $attributes['satisfy_customer_company_url'],
                    ],
                    [
                        'article_id' => $article->id,
                        'slug'       => ArticleDataTypeEnum::NAME->value,
                        'content'    => $attributes['satisfy_customer_name'],
                    ],
                    [
                        'article_id' => $article->id,
                        'slug'       => ArticleDataTypeEnum::COMPANY_NAME->value,
                        'content'    => $attributes['satisfy_customer_company_name'],
                    ],
                    [
                        'article_id' => $article->id,
                        'slug'       => ArticleDataTypeEnum::DESIGNATION->value,
                        'content'    => $attributes['designation'],
                    ],
                    [
                        'article_id' => $article->id,
                        'slug'       => ArticleDataTypeEnum::IMAGE->value,
                        'content'    => ImageHelper::upload($attributes['image'] ?? null, 'customer-satisfy'),
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
                        'slug'          => ArticleLangDataTypeEnum::SATISFY_CUSTOMER_MESSAGE->value,
                        'large_content' => $attributes['satisfy_customer_message'],
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
                'message' => localize("Customer Satisfy Content create error"),
                'title'   => localize('Customer Satisfy Content'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update CMS Customer satisfy content
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
                'slug'         => ArticleTypeEnum::CUSTOMER_SATISFY_CONTENT->value,
                'article_name' => $attributes['customer_satisfy_content'],
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
                        'slug'       => ArticleDataTypeEnum::URL->value,
                        'content'    => $attributes['satisfy_customer_company_url'],
                    ],
                    [
                        'article_id' => $articleId,
                        'slug'       => ArticleDataTypeEnum::NAME->value,
                        'content'    => $attributes['satisfy_customer_name'],
                    ],
                    [
                        'article_id' => $articleId,
                        'slug'       => ArticleDataTypeEnum::COMPANY_NAME->value,
                        'content'    => $attributes['satisfy_customer_company_name'],
                    ],
                    [
                        'article_id' => $articleId,
                        'slug'       => ArticleDataTypeEnum::DESIGNATION->value,
                        'content'    => $attributes['designation'],
                    ],
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

                            if (isset($attributes['image'])) {
                                $data['content'] = ImageHelper::upload($attributes['image'] ?? null, 'customer-satisfy', $articleData['content']);
                                $this->articleDataRepository->updateByCondition(['article_id' => $articleId, 'slug' => $data['slug']], $data);
                            }

                        }

                    } else {

                        if (isset($data['content'])) {
                            $this->articleDataRepository->create($data);
                        } elseif (isset($attributes['image'])) {
                            $data['content'] = ImageHelper::upload($attributes['image'] ?? null, 'customer-satisfy');
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
                        'slug'          => ArticleLangDataTypeEnum::SATISFY_CUSTOMER_MESSAGE->value,
                        'large_content' => $attributes['satisfy_customer_message'],
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
                'message' => localize("Customer Satisfy Content update error"),
                'title'   => localize('Customer Satisfy Content'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Delete CMS Customer satisfy content
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes): bool
    {
        $articleId = $attributes['article_id'];

        try {
            DB::beginTransaction();
            /**
             * Delete Article Data Start
             */
            $articleDatas = $this->articleDataRepository->all(['article_id' => $articleId]);

            foreach ($articleDatas as $articleData) {

                if ($articleData['slug'] == 'image' && $articleData['content']) {
                    delete_file('public/' . $articleData['content']);
                }

            }

            $this->articleDataRepository->deleteByCondition(['article_id' => $articleId]);
            /**
             * Delete Article Data End
             */

            /**
             * Delete Article Lang Data Start
             */
            $this->articleLangDataRepository->deleteByCondition(['article_id' => $articleId]);

            /**
             * Delete Article Start
             */
            $this->articleRepository->destroyById($articleId);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Customer Satisfy Content delete error"),
                'title'   => localize('Customer Satisfy Content'),
                // 'errors'  => $exception->getMessage(),
            ], 422));
        }

    }

}
