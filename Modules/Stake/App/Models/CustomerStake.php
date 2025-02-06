<?php

namespace Modules\Stake\App\Models;

use App\Models\AcceptCurrency;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Stake\App\Enums\CustomerStakeEnum;

class CustomerStake extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'stake_plan_id',
        'accept_currency_id',
        'user_id',
        'locked_amount',
        'duration',
        'interest_rate',
        'annual_rate',
        'status',
        'redemption_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'stake_plan_id'      => 'integer',
        'accept_currency_id' => 'integer',
        'user_id'            => 'string',
        'locked_amount'      => 'float',
        'duration'           => 'integer',
        'interest_rate'      => 'float',
        'annual_rate'        => 'float',
        'status'             => CustomerStakeEnum::class,
        'redemption_at'      => 'datetime',
        'created_at'         => 'datetime',
        'updated_at'         => 'datetime',
    ];

    /**
     * Customer Information
     * @return BelongsTo
     */
    public function customerInfo(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_id', 'user_id');
    }

    /**
     * Interest Information
     * @return BelongsTo
     */
    public function interestInfo(): BelongsTo
    {
        return $this->belongsTo(CustomerStakeInterest::class, 'id', 'customer_stake_id');
    }

    /**
     * Accept Currency
     *
     * @return BelongsTo
     */
    public function acceptCurrency(): BelongsTo
    {
        return $this->belongsTo(AcceptCurrency::class, 'accept_currency_id', 'id');
    }

    public function getCreatedAtAttribute($value): string
    {

        if ($value === null) {
            return '';
        } else {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        }

    }

    public function getRedemptionAtAttribute($value): string
    {

        if ($value === null) {
            return '';
        } else {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        }

    }

}