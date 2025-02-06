<?php

namespace App\Services;

use App\Facades\Localizer;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class BuildService
{
    /**
     * BuildService constructor.
     *
     */
    public function __construct(
        protected LanguageRepositoryInterface $languageRepository,
    ) {
    }

    /**
     * Form data of app setting
     *
     * @return array
     */
    public function formData(int $languageId): array
    {
        $language = $this->languageRepository->findOrFail($languageId);

        return compact('language');
    }

    /**
     * Create language build
     *
     * @param  array  $attributes
     * @return void
     * @throws Exception
     */
    public function create(array $attributes): void
    {
        $languageId = $attributes['language_id'];

        try {
            $language = $this->languageRepository->findOrFail($languageId);
            $local    = [];

            foreach ($attributes['key'] as $key => $value) {
                $local[$value] = $attributes['label'][$key];
            }

            Localizer::bulkStore($local, $language->symbol);

        } catch (Exception $exception) {

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Language build create error"),
                'title'   => localize("Language build"),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update language build
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $languageId = $attributes['language_id'];
        $buildKey   = $attributes['build_key'];

        try {
            $language = $this->languageRepository->findOrFail($languageId);

            $key   = $attributes['key'][0];
            $label = $attributes['label'][0];

            Localizer::deleteLocal($buildKey, $language->symbol);
            Localizer::storeLocal($key, $label ?? '', $language->symbol);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Language build update error"),
                'title'   => localize("Language build"),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Delete language
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes): bool
    {
        $languageId = $attributes['language_id'];
        $key        = $attributes['key'];

        try {
            $language = $this->languageRepository->findOrFail($languageId);

            Localizer::deleteLocal($key, $language->symbol);

            return true;
        } catch (Exception $exception) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Language build delete error"),
                'title'   => localize("Language build"),
            ], 422));
        }

    }

}
