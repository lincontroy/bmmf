<?php

namespace Modules\B2xloan\App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\B2xloan\App\Enums\B2xLoanStatusEnum;
use Modules\B2xloan\App\Enums\B2xLoanWithdrawStatusEnum;
use Modules\B2xloan\App\Models\B2xLoanPackage as B2xLoanPackageAlias;
use Modules\B2xloan\Database\factories\B2xLoanFactory;

class B2xLoan extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'b2x_loan_package_id',
        'interest_percent',
        'loan_amount',
        'hold_btc_amount',
        'installment_amount',
        'number_of_installment',
        'paid_installment',
        'remaining_installment',
        'checker_note',
        'status',
        'withdraw_status',
        'withdraw_note',
        'payment_gateway_id',
        'currency',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'customer_id' => 'integer',
        'b2x_loan_package_id' => 'integer',
        'interest_percent' => 'decimal:6',
        'loan_amount' => 'decimal:6',
        'hold_btc_amount' => 'decimal:6',
        'installment_amount' => 'decimal:6',
        'number_of_installment' => 'decimal:6',
        'paid_installment' => 'decimal:6',
        'remaining_installment' => 'decimal:6',
        'checker_note' => 'string',
        'withdraw_note' => 'string',
        'payment_gateway_id' => 'integer',
        'currency' => 'string',
        'status' => B2xLoanStatusEnum::class,
        'withdraw_status' => B2xLoanWithdrawStatusEnum::class,
    ];

    protected static function newFactory(): B2xLoanFactory
    {
        return B2xLoanFactory::new();
    }


    /**
     * Customer Information
     *
     * @return BelongsTo
     */
    public function customerInfo(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * B2x package info Time
     *
     * @return BelongsTo
     */
    public function packageInfo(): BelongsTo
    {
        return $this->belongsTo(B2xLoanPackageAlias::class, 'b2x_loan_package_id', 'id');
    }
}
