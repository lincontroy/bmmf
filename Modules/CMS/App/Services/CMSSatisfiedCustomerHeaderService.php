<?php

namespace Modules\CMS\App\Services;

use App\Enums\ArticleLangDataTypeEnum;
use App\Repositories\Interfaces\ArticleDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleLangDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class CMSSatisfiedCustomerHeaderService
{
    /**
     * CMSSatisfiedCustomerHeaderService constructor.
     *
     */
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
        protected ArticleDataRepositoryInterface $articleDataRepository,
        protected ArticleLangDataRepositoryInterface $articleLangDataRepository,
    ) {
    }

    /**
     * Update CMS Satisfied Customer Header
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
                'article_name' => $attributes['satisfied_customer_header'],
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
                        'slug'          => ArticleLangDataTypeEnum::SATISFIED_CUSTOMER_HEADER_TITLE->value,
                        'small_content' => $attributes['satisfied_customer_header_title'],
                    ],
                    [
                        'article_id'    => $articleId,
                        'language_id'   => $attributes['header_language_id'],
                        'slug'          => ArticleLangDataTypeEnum::SATISFIED_CUSTOMER_HEADER_CUSTOMER->value,
                        'large_content' => $attributes['satisfied_customer_header_content'],
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
                'message' => localize("Satisfied Customer Header update error"),
                'title'   => localize('Satisfied Customer Header'),
                'errors'  => $exception,
            ], 422));
        }

    }

}
