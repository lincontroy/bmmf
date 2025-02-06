<?php

namespace App\Repositories\Eloquent;

use App\Models\SetupCommission;
use App\Repositories\Interfaces\CommissionSetupRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommissionSetupRepository extends BaseRepository implements CommissionSetupRepositoryInterface
{
    public function __construct(SetupCommission $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $attributes
     * @return object|null
     */
    public function getCommission(array $attributes = []): ?object
    {
        return $this->model::where('personal_invest', '<=', $attributes['personal_invest'])
                           ->where('total_invest', '<=', $attributes['total_invest'])
                           ->where('level_name', $attributes['level_name'])
                           ->first();
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public function updateByUserId(string $userId, array $attributes): bool
    {
        return $this->model->where('user_id', $userId)->update($attributes);
    }

    public function tableEmpty()
    {
        try {
            DB::table($this->model->getTable())->truncate();
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to truncate table: ' . $e->getMessage());
            return false;
        }
    }

}
