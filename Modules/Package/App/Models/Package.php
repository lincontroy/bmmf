<?php

namespace Modules\Package\App\Models;

use App\Enums\InterestTypeStatus;
use App\Enums\InvestTypeStatus;
use App\Enums\ReturnTypeStatus;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Package\App\Enums\CapitalBackEnum;

class Package extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plan_time_id',
        'name',
        'invest_type',
        'min_price',
        'max_price',
        'interest_type',
        'interest',
        'return_type',
        'repeat_time',
        'capital_back',
        'image',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'plan_time_id'  => 'integer',
        'name'          => 'string',
        'invest_type'   => InvestTypeStatus::class,
        'min_price'     => 'float',
        'max_price'     => 'float',
        'interest_type' => InterestTypeStatus::class,
        'interest'      => 'float',
        'return_type'   => ReturnTypeStatus::class,
        'repeat_time'   => 'integer',
        'capital_back'  => CapitalBackEnum::class,
        'image'         => 'string',
        'status'        => StatusEnum::class,
        'created_by'    => 'integer',
        'updated_by'    => 'integer',
    ];

    /**
     * Plan Time
     *
     * @return BelongsTo
     */
    public function planTime(): BelongsTo
    {
        return $this->belongsTo(PlanTime::class);
    }
}
