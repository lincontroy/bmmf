<?php

namespace Modules\Package\App\Services;

use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Modules\Package\App\Repositories\Interfaces\PackageRepositoryInterface;
use Modules\Package\App\Repositories\Interfaces\PlanTimeRepositoryInterface;

class PlanTimeService
{
    /**
     * PlanTimeService constructor.
     *
     */
    public function __construct(
        private PackageRepositoryInterface $packageRepository,
        private ArticleRepositoryInterface $articleRepository,
        private PlanTimeRepositoryInterface $planTimeRepository,
    ) {
    }

    /**
     * Update plan time
     *
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $planTimeId = $attributes['plan_time_id'];

        try {
            DB::beginTransaction();

            $this->planTimeRepository->updateById($planTimeId, $attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => localize("Plan time update error"),
                    'title'   => localize('Plan Time'),
                    'errors'  => $exception,
                ], 422)
            );
        }
    }

    /**
     * Create Plan time
     *
     * @param array $attributes
     * @return array
     * @throws Exception
     */
    public function create(array $attributes): object
    {
        try {
            DB::beginTransaction();
            $planTime = $this->planTimeRepository->create($attributes);
            DB::commit();

            return $planTime;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * get data by id
     * @param mixed $id
     * @return object
     */
    public function findById($id): object
    {
        $planTime = $this->planTimeRepository->find($id);

        return $planTime;
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
        $planTimeId = $attributes['plan_time_id'];

        try {
            DB::beginTransaction();

            $this->planTimeRepository->destroyById($planTimeId);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => localize("Package delete error"),
                    'title'   => localize('Package delete error'),
                    'errors'  => $exception,
                ], 422)
            );
        }
    }

}
