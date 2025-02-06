<?php

namespace Modules\Merchant\App\Models;

use App\Models\PaymentGateway;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Merchant\App\Enums\MerchantPaymentTransactionStatusEnum;
use Modules\Merchant\App\Models\MerchantPaymentInfo;

class MerchantPaymentTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'payment_gateway_id',
        'transaction_hash',
        'amount',
        'data',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'payment_gateway_id' => 'integer',
        'transaction_hash'   => 'string',
        'amount'             => 'float',
        'data'               => 'json',
        'status'             => MerchantPaymentTransactionStatusEnum::class,
    ];

    /**
     * Payment Gateway
     *
     * @return BelongsTo
     */
    public function paymentGateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    /**
     * Payment Gateway
     *
     * @return HasOne
     */
    public function merchantPaymentInfo(): HasOne
    {
        return $this->hasOne(MerchantPaymentInfo::class);
    }

}
