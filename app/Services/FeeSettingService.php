<?php

namespace App\Services;

use App\Enums\FeeSettingLevelEnum;
use App\Repositories\Interfaces\FeeSettingRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class FeeSettingService
{
    /**
     * FeeSettingService constructor.
     *
     */
    public function __construct(
        protected FeeSettingRepositoryInterface $feeSettingRepository,
    ) {
    }

    /**
     * Form data of app setting
     *
     * @return array
     */
    public function formData(): array
    {
        $feeSettingLevels = FeeSettingLevelEnum::values();

        return compact('feeSettingLevels');
    }

    /**
     * Find language or throw 404
     *
     * @param  int  $id
     * @return object
     */
    public function findOrFail(int $id): object
    {
        return $this->feeSettingRepository->findOrFail($id);
    }

    /**
     * Find language or throw 404
     *
     * @param  int  $id
     * @return object
     */
    public function findByAttributes(array $attribute): object
    {
        return $this->feeSettingRepository->findByAttributes($attribute);
    }

    /**
     * All languages
     *
     * @param array $attributes
     * @return object
     */
    public function all(array $attributes = []): object
    {
        return $this->feeSettingRepository->all($attributes);
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
        $attributes['status'] = '1';

        try {
            DB::beginTransaction();

            $feeSetting = $this->feeSettingRepository->create($attributes);

            DB::commit();

            return $feeSetting;

        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Fee setting create error"),
                'title'   => localize("Fee setting"),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update feeSetting
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $feeSettingId = $attributes['fee_setting_id'];

        try {
            DB::beginTransaction();

            $this->feeSettingRepository->updateById($feeSettingId, $attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Fee setting update error"),
                'title'   => localize("Fee setting"),
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
        $feeSettingId = $attributes['fee_setting_id'];

        try {
            DB::beginTransaction();

            $language = $this->feeSettingRepository->findOrFail($feeSettingId);

            if ($language && $language->logo) {
                delete_file('public/' . $language->logo);
            }

            $this->feeSettingRepository->destroyById($feeSettingId);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Fee setting delete error"),
                'title'   => localize("Fee setting"),
                // 'errors'  => $exception->getMessage(),
            ], 422));
        }

    }

    /**
     * Find fee by level- Deposit, Withdraw, Transfer
     * @param string $level
     * @return object|null
     */
    public function findFeeByLevel(string $level): ?object
    {
        return $this->feeSettingRepository->firstWhere('level', $level);
    }

}
