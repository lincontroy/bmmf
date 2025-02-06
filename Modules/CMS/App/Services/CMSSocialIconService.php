<?php

namespace Modules\CMS\App\Services;

use App\Enums\ArticleDataTypeEnum;
use App\Enums\ArticleTypeEnum;
use App\Helpers\ImageHelper;
use App\Repositories\Interfaces\ArticleDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleLangDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class CMSSocialIconService
{
    /**
     * CMSSocialIconService constructor.
     *
     */
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
        protected ArticleDataRepositoryInterface $articleDataRepository,
        protected ArticleLangDataRepositoryInterface $articleLangDataRepository,
    ) {
    }

    /**
     * Create CMS Social Icon
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
                'slug'         => ArticleTypeEnum::SOCIAL_ICON->value,
                'article_name' => $attributes['social_icon_name'],
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
                        'content'    => ImageHelper::upload($attributes['image'] ?? null, 'social-icon'),
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

            }

            DB::commit();

            return true;

        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Social Icon create error"),
                'title'   => localize('Social Icon'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update CMS Social Icon
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
                'slug'         => ArticleTypeEnum::SOCIAL_ICON->value,
                'article_name' => $attributes['social_icon_name'],
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
                                $data['content'] = ImageHelper::upload($attributes['image'] ?? null, 'social-icon', $articleData['content']);
                                $this->articleDataRepository->updateByCondition(['article_id' => $articleId, 'slug' => $data['slug']], $data);
                            }

                        }

                    } else {
                        $this->articleDataRepository->create($data);
                    }

                }

                /**
                 * Article Data insert end
                 */

            }

            DB::commit();

            return true;

        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Social Icon update error"),
                'title'   => localize('Social Icon'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Delete CMS Social Icon
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

                if ($articleData['slug'] == ArticleDataTypeEnum::IMAGE->value && $articleData['content']) {
                    delete_file('public/' . $articleData['content']);
                }

            }

            $this->articleDataRepository->deleteByCondition(['article_id' => $articleId]);
            /**
             * Delete Article Data End
             */

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
                'message' => localize("Social Icon delete error"),
                'title'   => localize('Social Icon'),
                // 'errors'  => $exception->getMessage(),
            ], 422));
        }

    }

}
