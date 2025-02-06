<?php

namespace App\Models;

use App\Enums\PaymentRequestEnum;
use App\Enums\PaymentRequestStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Merchant\App\Models\MerchantPaymentUrl;

class PaymentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        "payment_gateway_id",
        "merchant_payment_url_id",
        "txn_type",
        "txn_id",
        "txn_token",
        "currency",
        "txn_amount",
        'usd_value',
        "fees",
        "user",
        "txn_data",
        "tx_status",
        "comment",
        "ip_address",
        "expired_at",
    ];

    protected $casts = [
        'payment_gateway_id'      => 'integer',
        'merchant_payment_url_id' => 'integer',
        'txn_type'                => PaymentRequestEnum::class,
        'txn_id'                  => 'string',
        'txn_token'               => 'string',
        'currency'                => 'string',
        'txn_amount'              => 'float',
        'usd_value'               => 'float',
        'fees'                    => 'float',
        'user'                    => 'string',
        'txn_data'                => 'string',
        'comment'                 => 'string',
        'ip_address'              => 'string',
        'tx_status'               => PaymentRequestStatusEnum::class,
        'expired_at'              => 'datetime',
    ];

    /**
     * Merchant Payment Url
     *
     * @return BelongsTo
     */
    public function merchantPaymentUrl(): BelongsTo
    {
        return $this->belongsTo(MerchantPaymentUrl::class, 'merchant_payment_url_id');
    }
}
