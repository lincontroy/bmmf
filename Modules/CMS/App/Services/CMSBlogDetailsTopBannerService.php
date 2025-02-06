<?php

namespace Modules\CMS\App\Services;

use App\Enums\ArticleLangDataTypeEnum;
use App\Repositories\Interfaces\ArticleDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleLangDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use App\Enums\ArticleDataTypeEnum;
use App\Helpers\ImageHelper;

class CMSBlogDetailsTopBannerService
{
    /**
     * CMSBlogDetailsTopBannerService constructor.
     *
     */
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
        protected ArticleDataRepositoryInterface $articleDataRepository,
        protected ArticleLangDataRepositoryInterface $articleLangDataRepository,
    ) {
    }

    /**
     * Update CMS Blog details top banner
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
                'article_name' => $attributes['blog_details_top_banner'],
                'status'       => $attributes['details_top_banner_status'],
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

                            if (isset($attributes['blog_details_top_banner_image'])) {
                                $data['content'] = ImageHelper::upload($attributes['blog_details_top_banner_image'] ?? null, 'blog', $articleData['content']);
                                $this->articleDataRepository->updateByCondition(['article_id' => $articleId, 'slug' => $data['slug']], $data);
                            }
                        }

                    } else {

                        if (isset($data['content'])) {
                            $this->articleDataRepository->create($data);
                        } elseif (isset($attributes['blog_details_top_banner_image'])) {
                            $data['content'] = ImageHelper::upload($attributes['blog_details_top_banner_image'] ?? null, 'blog');
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
                        'language_id'   => $attributes['details_top_banner_language_id'],
                        'slug'          => ArticleLangDataTypeEnum::BLOG_DETAILS_TOP_BANNER_TITLE->value,
                        'small_content' => $attributes['blog_details_top_banner_title'],
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
                'message' => localize("Blog Details Top Banner update error"),
                'title'   => localize('Blog Details Top Banner'),
                'errors'  => $exception,
            ], 422));
        }

    }

}
