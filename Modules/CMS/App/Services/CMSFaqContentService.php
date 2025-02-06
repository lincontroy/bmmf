<?php

namespace Modules\CMS\App\Services;

use App\Enums\ArticleLangDataTypeEnum;
use App\Enums\ArticleTypeEnum;
use App\Repositories\Interfaces\ArticleDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleLangDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class CMSFaqContentService
{
    /**
     * CMSFaqContentService constructor.
     *
     */
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
        protected ArticleDataRepositoryInterface $articleDataRepository,
        protected ArticleLangDataRepositoryInterface $articleLangDataRepository,
    ) {
    }

    /**
     * Create CMS Faq content
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
                'slug'         => ArticleTypeEnum::FAQ_CONTENT->value,
                'article_name' => $attributes['faq_content'],
                'status'       => $attributes['status'],
            ];
            $article = $this->articleRepository->create($articleInsertData);

            if ($article) {
                /**
                 * Article Lang Data insert start
                 */
                $articleLangDataInsertData = [
                    [
                        'article_id'    => $article->id,
                        'language_id'   => $attributes['language_id'],
                        'slug'          => ArticleLangDataTypeEnum::FAQ_CONTENT_DATA->value,
                        'small_content' => $attributes['question_content'],
                        'large_content' => $attributes['answer_content'],
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
                'message' => localize("Faq Content create error"),
                'title'   => localize('Faq Content'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update CMS Faq content
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
                'slug'         => ArticleTypeEnum::FAQ_CONTENT->value,
                'article_name' => $attributes['faq_content'],
                'status'       => $attributes['status'],
            ];

            $articleUpdateCheck = $this->articleRepository->updateById($articleId, $articleUpdateData);

            if ($articleUpdateCheck) {

                /**
                 * Article Lang Data insert start
                 */
                $articleLangDataInsertData = [
                    [
                        'article_id'    => $articleId,
                        'language_id'   => $attributes['language_id'],
                        'slug'          => ArticleLangDataTypeEnum::FAQ_CONTENT_DATA->value,
                        'small_content' => $attributes['question_content'],
                        'large_content' => $attributes['answer_content'],
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
                'message' => localize("Faq Content update error"),
                'title'   => localize('Faq Content'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Delete CMS Faq content
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
                'message' => localize("Faq Content delete error"),
                'title'   => localize('Faq Content'),
                // 'errors'  => $exception->getMessage(),
            ], 422));
        }

    }

}
