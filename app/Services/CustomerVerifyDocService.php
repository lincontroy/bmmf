<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Http\Resources\PackageResource;
use App\Repositories\Interfaces\CustomerVerifyRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Package\App\Enums\CapitalBackEnum;
use Modules\Package\App\Enums\InterestTypeEnum;
use Modules\Package\App\Enums\InvestTypeEnum;
use Modules\Package\App\Enums\ReturnTypeEnum;
use Modules\Package\App\Repositories\Interfaces\PackageRepositoryInterface;

class CustomerVerifyDocService
{
    /**
     * CustomerVerifyDocService constructor.
     *
     */
    public function __construct(
        private CustomerVerifyRepositoryInterface $customerVerifyRepository,
        private PackageRepositoryInterface $packageRepository
    ) {
    }

    public function findPackages(): ?object
    {
        $packages = $this->packageRepository->findWhere('status', StatusEnum::ACTIVE->value);

        if ($packages) {
            return PackageResource::collection($packages);
        }

        return (object) [];
    }

    /**
     * Required data to populate form
     *
     * @return array
     */
    public function formData(): array
    {
        $investmentType = InvestTypeEnum::toArray();
        $interestType   = InterestTypeEnum::toArray();
        $returnType     = ReturnTypeEnum::toArray();
        $capitalBack    = CapitalBackEnum::toArray();

        return compact('investmentType', 'interestType', 'returnType', 'capitalBack');
    }

    /**
     * get data by id
     * @param mixed $id
     * @return object
     */
    public function findById($id): object
    {
        $package = $this->packageRepository->find($id);

        return $package;
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

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => "Package update error",
                    'title'   => 'Package',
                    'errors'  => $exception,
                ], 422)
            );
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

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => "Package delete error",
                    'title'   => 'Package delete error',
                    'errors'  => $exception,
                ], 422)
            );
        }

    }

}
