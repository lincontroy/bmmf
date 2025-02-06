<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Package\App\Models\Package;

class Investment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'package_id',
        'user_id',
        'invest_amount',
        'invest_qty',
        'total_invest_amount',
        'status',
        'expiry_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'package_id'          => 'integer',
        'user_id'             => 'string',
        'invest_amount'       => 'decimal:4',
        'total_invest_amount' => 'decimal:4',
        'invest_qty'          => 'integer',
        'expiry_at'           => 'date',
        'status'              => StatusEnum::class,
    ];

    /**
     * currency
     *
     * @return BelongsTo
     */
    public function customerInfo(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_id', 'user_id');
    }

    /**
     * currency
     *
     * @return BelongsTo
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    /**
     * currency
     *
     * @return HasOne
     */
    public function details(): HasOne
    {
        return $this->hasOne(InvestmentDetail::class, 'investment_id', 'id');
    }
}
