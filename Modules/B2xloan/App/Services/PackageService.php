<?php

namespace Modules\B2xloan\App\Services;

use App\Enums\StatusEnum;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\B2xloan\App\Repositories\Interfaces\PackageRepositoryInterface;

class PackageService
{
    /**
     * PackageService constructor.
     *
     */
    public function __construct(
        private PackageRepositoryInterface $packageRepository,
    ) {
    }

    /**
     * get data by id
     * @param mixed $id
     * @return object
     */
    public function findById($id): object
    {
        return $this->packageRepository->find($id);
    }

    /**
     * get data by id
     * @param mixed $month
     * @return object
     */
    public function feeInfo(int $month): object
    {
        return $this->packageRepository->firstWhere('no_of_month', (string) $month);
    }

    /**
     * get all active data
     * @param mixed $id
     * @return object
     */
    public function allActive(array $attributes = []): object
    {
        return $this->packageRepository->findWhere('status', StatusEnum::ACTIVE->value);
    }

    /**
     * Update package
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $packageId = $attributes['package_id'];

        try {
            DB::beginTransaction();

            $this->packageRepository->updateById($packageId, $attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Package update error"),
                'title'   => localize('Package'),
                'errors'  => $exception,
            ], 422));
        }
    }

    /**
     * Create Package
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        try {
            DB::beginTransaction();
            $package = $this->packageRepository->create($attributes);
            DB::commit();

            return $package;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * Delete expense
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes): bool
    {
        $packageId = $attributes['package_id'];

        try {
            DB::beginTransaction();

            $this->packageRepository->destroyById($packageId);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Package delete error"),
                'title'   => localize('Package delete error'),
                'errors'  => $exception,
            ], 422));
        }
    }

}
