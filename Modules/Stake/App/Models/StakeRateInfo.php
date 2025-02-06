<?php

namespace Modules\Stake\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StakeRateInfo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "stake_rate_info";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stake_plan_id',
        'duration',
        'rate',
        'annual_rate',
        'min_amount',
        'max_amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'stake_plan_id' => 'integer',
        'duration'      => 'integer',
        'rate'          => 'float',
        'annual_rate'   => 'float',
        'min_amount'    => 'float',
        'max_amount'    => 'float',
    ];
}