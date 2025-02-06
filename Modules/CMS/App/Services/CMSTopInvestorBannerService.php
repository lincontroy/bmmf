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

class CMSTopInvestorBannerService
{
    /**
     * CMSTopInvestorBannerService constructor.
     *
     */
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
        protected ArticleDataRepositoryInterface $articleDataRepository,
        protected ArticleLangDataRepositoryInterface $articleLangDataRepository,
    ) {
    }

    /**
     * Update CMS top investor banner
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
                'article_name' => $attributes['top_investor_banner'],
                'status'       => $attributes['banner_status'],
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

                            if (isset($attributes['banner_image'])) {
                                $data['content'] = ImageHelper::upload($attributes['banner_image'] ?? null, 'top-investor', $articleData['content']);
                                $this->articleDataRepository->updateByCondition(['article_id' => $articleId, 'slug' => $data['slug']], $data);
                            }

                        }

                    } else {

                        if (isset($data['content'])) {
                            $this->articleDataRepository->create($data);
                        } elseif (isset($attributes['banner_image'])) {
                            $data['content'] = ImageHelper::upload($attributes['banner_image'] ?? null, 'top-investor');
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
                        'language_id'   => $attributes['banner_language_id'],
                        'slug'          => ArticleLangDataTypeEnum::TOP_INVESTOR_BANNER_TITLE->value,
                        'small_content' => $attributes['top_investor_banner_title'],
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
                'message' => localize("Top Investor Banner update error"),
                'title'   => localize('Top Investor Banner'),
                'errors'  => $exception,
            ], 422));
        }

    }

}
