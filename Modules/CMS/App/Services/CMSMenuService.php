<?php

namespace Modules\CMS\App\Services;

use App\Enums\StatusEnum;
use App\Repositories\Interfaces\ArticleLangDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\CMS\App\Enums\CMSMenuListEnum;

class CMSMenuService
{
    /**
     * CMSMenuService constructor.
     *
     */
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
        protected ArticleLangDataRepositoryInterface $articleLangDataRepository,
    ) {
    }

    /**
     * CMS Menu form data
     *
     *
     * @return array
     */
    public function formData(): array
    {
        $cmsMenuLists = CMSMenuListEnum::values();

        return compact('cmsMenuLists');
    }

    /**
     * Update CMS Menu
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

            $this->articleRepository->updateById($articleId, ['status' => StatusEnum::ACTIVE->value]);

            $articleLangData = $this->articleLangDataRepository->first(['slug' => $attributes['menu_slug'], 'language_id' => $attributes['language_id']]);

            if ($articleLangData) {
                $updateData = [
                    'article_id'    => $articleId,
                    'slug'          => $attributes['menu_slug'],
                    'language_id'   => $attributes['language_id'],
                    'small_content' => $attributes['menu_name'],
                ];
                $this->articleLangDataRepository->updateById($articleLangData->id, $updateData);
            } else {
                $createData = [
                    'article_id'    => $articleId,
                    'slug'          => $attributes['menu_slug'],
                    'language_id'   => $attributes['language_id'],
                    'small_content' => $attributes['menu_name'],
                    'status'        => StatusEnum::ACTIVE->value,
                ];
                $this->articleLangDataRepository->create($createData);
            }

            DB::commit();

            return true;

        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Menu update error"),
                'title'   => localize('Menu'),
                'errors'  => $exception,
            ], 422));
        }

    }

}
