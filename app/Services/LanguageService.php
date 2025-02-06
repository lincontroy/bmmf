<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Facades\Localizer;
use App\Helpers\ImageHelper;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LanguageService
{
    /**
     * LanguageService constructor.
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
    public function formData(): array
    {
        $languages = $this->languageRepository->all();

        return compact('languages');
    }

    /**
     * Find language or throw 404
     *
     * @param  int  $id
     * @return object
     */
    public function findOrFail(int $id): object
    {
        return $this->languageRepository->findOrFail($id);
    }

    /**
     * Find language or throw 404
     *
     * @param  array  $attribute
     * @return object
     */
    public function findByAttributes(array $attribute): object
    {
        return $this->languageRepository->findByAttributes($attribute);
    }

    /**
     * All languages
     *
     * @param array $attributes
     * @return object
     */
    public function all(array $attributes = []): object
    {
        return $this->languageRepository->all($attributes);
    }

    /**
     * All active languages
     *
     * @return object
     */
    public function activeLanguages(): object
    {
        return $this->languageRepository->all(['status' => StatusEnum::ACTIVE->value]);
    }

    /**
     * Create language
     *
     * @param  array  $attributes
     * @return object
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        $attributes['logo']   = ImageHelper::upload($attributes['logo'] ?? null, 'language');
        $attributes['status'] = StatusEnum::ACTIVE->value;

        try {
            DB::beginTransaction();

            $language = $this->languageRepository->create($attributes);

            $localizePath = Localizer::getLocalizePath($attributes['symbol']);
            $local        = Localizer::getLocalizeData('en');

            File::put($localizePath, json_encode($local));

            DB::commit();

            return $language;

        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Language create error"),
                'title'   => localize("Language"),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update language
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $languageId         = $attributes['language_id'];
        $attributes['logo'] = ImageHelper::upload($attributes['logo'] ?? null, 'language', $attributes['old_logo']);

        try {
            DB::beginTransaction();

            $this->languageRepository->updateById($languageId, $attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Language update error"),
                'title'   => localize("Language"),
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
        $languageId = $attributes['id'];

        try {
            DB::beginTransaction();

            $language = $this->languageRepository->findOrFail($languageId);

            if ($language && $language->logo) {
                delete_file('public/' . $language->logo);
            }

            $localizePath = Localizer::getLocalizePath($language['symbol']);
            $this->languageRepository->destroyById($languageId);

            File::delete($localizePath);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Language delete error"),
                'title'   => localize("Language"),
            ], 422));
        }

    }

}
