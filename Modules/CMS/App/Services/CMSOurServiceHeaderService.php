<?php

namespace Modules\CMS\App\Services;

use App\Enums\ArticleLangDataTypeEnum;
use App\Repositories\Interfaces\ArticleDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleLangDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class CMSOurServiceHeaderService
{
    /**
     * CMSOurServiceHeaderService constructor.
     *
     */
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
        protected ArticleDataRepositoryInterface $articleDataRepository,
        protected ArticleLangDataRepositoryInterface $articleLangDataRepository,
    ) {
    }

    /**
     * Update CMS Our Service banner
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
                'article_name' => $attributes['our_service_header'],
                'status'       => $attributes['header_status'],
            ];

            $articleUpdateCheck = $this->articleRepository->updateById($articleId, $articleUpdateData);

            if ($articleUpdateCheck) {

                /**
                 * Article Lang Data insert start
                 */
                $articleLangDataInsertData = [
                    [
                        'article_id'    => $articleId,
                        'language_id'   => $attributes['header_language_id'],
                        'slug'          => ArticleLangDataTypeEnum::OUR_SERVICE_HEADER_HEAD->value,
                        'small_content' => $attributes['our_service_header_head'],
                    ],
                    [
                        'article_id'    => $articleId,
                        'language_id'   => $attributes['header_language_id'],
                        'slug'          => ArticleLangDataTypeEnum::OUR_SERVICE_HEADER_CONTENT->value,
                        'large_content' => $attributes['our_service_header_content'],
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
                'message' => localize("Our Service Header update error"),
                'title'   => localize('Our Service Header'),
                'errors'  => $exception,
            ], 422));
        }

    }

}
