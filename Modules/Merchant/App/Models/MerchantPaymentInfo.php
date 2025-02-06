<?php

namespace Modules\Merchant\App\Models;

use App\Models\AcceptCurrency;
use App\Models\PaymentGateway;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Merchant\App\Enums\MerchantPaymentInfoStatusEnum;
use Modules\Merchant\App\Models\MerchantAcceptedCoin;

class MerchantPaymentInfo extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'merchant_account_id',
        'merchant_customer_info_id',
        'merchant_accepted_coin_id',
        'payment_gateway_id',
        'merchant_payment_transaction_id',
        'amount',
        'received_amount',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'merchant_account_id'             => 'integer',
        'merchant_customer_info_id'       => 'integer',
        'merchant_accepted_coin_id'       => 'integer',
        'payment_gateway_id'              => 'integer',
        'merchant_payment_transaction_id' => 'integer',
        'amount'                          => 'decimal:2',
        'received_amount'                 => 'decimal:2',
        'status'                          => MerchantPaymentInfoStatusEnum::class,
    ];

    /**
     * Customer Information
     *
     * @return BelongsTo
     */
    public function merchantAccountInfo(): BelongsTo
    {
        return $this->belongsTo(MerchantAccount::class, 'merchant_account_id');
    }

    /**
     * Merchant Customer
     *
     * @return BelongsTo
     */
    public function merchantAccount(): BelongsTo
    {
        return $this->belongsTo(MerchantAccount::class, 'merchant_account_id');
    }

    /**
     * Merchant Information
     *
     * @return BelongsTo
     */
    public function merchantCustomerInfo(): BelongsTo
    {
        return $this->belongsTo(MerchantCustomerInfo::class, 'merchant_customer_info_id');
    }

    /**
     * Merchant Accepted Coin Information
     *
     * @return BelongsTo
     */
    public function merchantCoinInfo(): BelongsTo
    {
        return $this->belongsTo(AcceptCurrency::class, 'merchant_accepted_coin_id');
    }

    /**
     * Get the car's owner.
     */
    public function merchantAcceptedCoin(): BelongsTo
    {
        return $this->belongsTo(MerchantAcceptedCoin::class, 'merchant_accepted_coin_id');
    }

    /**
     * Merchant Accepted Coin Information
     *
     * @return BelongsTo
     */
    public function merchantGatewayInfo(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class, 'payment_gateway_id');
    }

    /**
     * Merchant Accepted Coin Information
     *
     * @return BelongsTo
     */
    public function merchantPaymentTransaction(): BelongsTo
    {
        return $this->belongsTo(MerchantPaymentTransaction::class, 'merchant_payment_transaction_id');
    }
}
