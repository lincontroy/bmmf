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

class CMSContactAddressService
{
    /**
     * CMSContactAddressService constructor.
     *
     */
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
        protected ArticleDataRepositoryInterface $articleDataRepository,
        protected ArticleLangDataRepositoryInterface $articleLangDataRepository,
    ) {
    }

    /**
     * Create CMS blog content
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
                'slug'         => ArticleTypeEnum::CONTACT_ADDRESS->value,
                'article_name' => $attributes['contact_address'],
                'status'       => $attributes['status'],
            ];
            $article = $this->articleRepository->create($articleInsertData);

            if ($article) {
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
                        'slug'          => ArticleLangDataTypeEnum::CONTACT_ADDRESS_PLACE->value,
                        'small_content' => $attributes['contact_address_place'],
                    ],
                    [
                        'article_id'    => $article->id,
                        'language_id'   => $attributes['language_id'],
                        'slug'          => ArticleLangDataTypeEnum::CONTACT_ADDRESS_LOCATION->value,
                        'large_content' => $attributes['contact_address_location'],
                    ],
                    [
                        'article_id'    => $article->id,
                        'language_id'   => $attributes['language_id'],
                        'slug'          => ArticleLangDataTypeEnum::CONTACT_ADDRESS_CONTACT->value,
                        'small_content' => $attributes['contact_address_contact'],
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
                'message' => localize("Contact Address create error"),
                'title'   => localize('Contact Address'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update CMS blog content
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
                'slug'         => ArticleTypeEnum::CONTACT_ADDRESS->value,
                'article_name' => $attributes['contact_address'],
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
                        'slug'          => ArticleLangDataTypeEnum::CONTACT_ADDRESS_PLACE->value,
                        'small_content' => $attributes['contact_address_place'],
                    ],
                    [
                        'article_id'    => $articleId,
                        'language_id'   => $attributes['language_id'],
                        'slug'          => ArticleLangDataTypeEnum::CONTACT_ADDRESS_LOCATION->value,
                        'large_content' => $attributes['contact_address_location'],
                    ],
                    [
                        'article_id'    => $articleId,
                        'language_id'   => $attributes['language_id'],
                        'slug'          => ArticleLangDataTypeEnum::CONTACT_ADDRESS_CONTACT->value,
                        'small_content' => $attributes['contact_address_contact'],
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
                'message' => localize("Contact Address update error"),
                'title'   => localize('Contact Address'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Delete CMS blog content
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
                'message' => localize("Contact Address delete error"),
                'title'   => localize('Contact Address'),
                // 'errors'  => $exception->getMessage(),
            ], 422));
        }

    }

}
