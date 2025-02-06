<?php

namespace Modules\CMS\App\Services;

use App\Helpers\ImageHelper;
use App\Repositories\Interfaces\ArticleDataRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class CMSBgImageService
{
    /**
     * CMSBgImageService constructor.
     *
     */
    public function __construct(
        protected ArticleDataRepositoryInterface $articleDataRepository,
    ) {
    }

    /**
     * Update
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {

        $slug      = $attributes['slug'];
        $articleId = $attributes['article_id'];

        try {
            DB::beginTransaction();

            $articleData = $this->articleDataRepository->first(['article_id' => $articleId, 'slug' => $slug]);

            if ($articleData && isset($attributes['image'])) {
                $data = [
                    'article_id' => $articleId,
                    'slug'       => $slug,
                    'content'    => ImageHelper::upload($attributes['image'] ?? null, 'bg-image', $articleData['content']),
                ];
                $this->articleDataRepository->updateByCondition(['article_id' => $articleId, 'slug' => $slug], $data);
            }

            DB::commit();

            return true;

        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Bg image update error"),
                'title'   => localize('Bg image'),
                'errors'  => $exception,
            ], 422));
        }

    }

}
