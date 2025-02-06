<?php

namespace App\Models;

use App\Enums\InvestDetailStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestmentDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'investment_id',
        'user_id',
        'customer_id',
        'roi_time',
        'invest_qty',
        'roi_amount_per_qty',
        'roi_amount',
        'total_number_of_roi',
        'total_roi_amount',
        'paid_number_of_roi',
        'paid_roi_amount',
        'next_roi_at',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'investment_id'       => 'integer',
        'user_id'             => 'string',
        'customer_id'         => 'integer',
        'roi_time'            => 'integer',
        'invest_qty'          => 'integer',
        'roi_amount_per_qty'  => 'decimal:4',
        'roi_amount'          => 'decimal:4',
        'total_number_of_roi' => 'integer',
        'total_roi_amount'    => 'decimal:4',
        'paid_number_of_roi'  => 'integer',
        'paid_roi_amount'     => 'decimal:4',
        'next_roi_at'         => 'datetime',
        'status'              => InvestDetailStatusEnum::class,
    ];

    /**
     * currency
     *
     * @return BelongsTo
     */
    public function investment(): BelongsTo
    {
        return $this->belongsTo(Investment::class, 'investment_id', 'id');
    }
}
