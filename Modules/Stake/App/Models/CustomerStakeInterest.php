<?php

namespace Modules\Stake\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Stake\App\Enums\CustomerStakeInterestEnum;

class CustomerStakeInterest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'customer_id',
        'customer_stake_id',
        'accept_currency_id',
        'currency_symbol',
        'locked_amount',
        'interest_amount',
        'status',
        'redemption_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'customer_stake_id'  => 'integer',
        'accept_currency_id' => 'integer',
        'currency_symbol'    => 'string',
        'user_id'            => 'string',
        'customer_id'        => 'integer',
        'locked_amount'      => 'float',
        'interest_amount'    => 'float',
        'status'             => CustomerStakeInterestEnum::class,
        'redemption_at'      => 'datetime',
        'created_at'         => 'datetime',
        'updated_at'         => 'datetime',
    ];

    public function getCreatedAtAttribute($value): string
    {

        if ($value === null) {
            return '';
        } else {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        }

    }

}