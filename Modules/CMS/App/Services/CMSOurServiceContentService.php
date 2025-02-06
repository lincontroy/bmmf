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

class CMSOurServiceContentService
{
    /**
     * CMSOurServiceContentService constructor.
     *
     */
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
        protected ArticleDataRepositoryInterface $articleDataRepository,
        protected ArticleLangDataRepositoryInterface $articleLangDataRepository,
    ) {
    }

    /**
     * Create CMS Our Rate Content
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
                'slug'         => ArticleTypeEnum::OUR_SERVICE->value,
                'article_name' => $attributes['our_service'],
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
                        'content'    => ImageHelper::upload($attributes['image'] ?? null, 'our-service'),
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
                        'slug'          => ArticleLangDataTypeEnum::OUR_SERVICE_HEADER->value,
                        'small_content' => $attributes['our_service_content_header'],
                    ],
                    [
                        'article_id'    => $article->id,
                        'language_id'   => $attributes['language_id'],
                        'slug'          => ArticleLangDataTypeEnum::OUR_SERVICE_CONTENT->value,
                        'large_content' => $attributes['our_service_content'],
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
                'message' => localize("Our Service Content create error"),
                'title'   => localize('Our Service Content'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update CMS Our Service Content
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
                'slug'         => ArticleTypeEnum::OUR_SERVICE->value,
                'article_name' => $attributes['our_service'],
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
                ];

                foreach ($articleDataInsertData as $data) {
                    $articleData = $this->articleDataRepository->first(['article_id' => $articleId, 'slug' => $data['slug']]);

                    if ($articleData) {

                        if ($data['slug'] != ArticleDataTypeEnum::IMAGE->value) {
                            $this->articleDataRepository->updateByCondition(['article_id' => $articleId, 'slug' => $data['slug']], $data);
                        } elseif ($data['slug'] == ArticleDataTypeEnum::IMAGE->value) {

                            if (isset($attributes['image'])) {
                                $data['content'] = ImageHelper::upload($attributes['image'] ?? null, 'our-service', $articleData['content']);
                                $this->articleDataRepository->updateByCondition(['article_id' => $articleId, 'slug' => $data['slug']], $data);
                            }

                        }

                    } else {

                        if (isset($data['content'])) {
                            $this->articleDataRepository->create($data);
                        } elseif (isset($attributes['image'])) {
                            $data['content'] = ImageHelper::upload($attributes['image'] ?? null, 'our-service');
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
                        'slug'          => ArticleLangDataTypeEnum::OUR_SERVICE_HEADER->value,
                        'small_content' => $attributes['our_service_content_header'],
                    ],
                    [
                        'article_id'    => $articleId,
                        'language_id'   => $attributes['language_id'],
                        'slug'          => ArticleLangDataTypeEnum::OUR_SERVICE_CONTENT->value,
                        'large_content' => $attributes['our_service_content'],
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
                'message' => localize("Our Service Content update error"),
                'title'   => localize('Our Service Content'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Delete CMS Our Service Content
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
                'message' => localize("Our Service Content delete error"),
                'title'   => localize('Our Service Content'),
                // 'errors'  => $exception->getMessage(),
            ], 422));
        }

    }

}
