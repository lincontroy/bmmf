<?php

namespace Modules\Merchant\App\Models;

use App\Models\AcceptCurrency;
use App\Models\PaymentGateway;
use App\Models\WithdrawalAccount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Merchant\App\Enums\MerchantWithdrawEnum;

class MerchantWithdraw extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'merchant_account_id',
        'user_id',
        'accept_currency_id',
        'wallet_id',
        'method',
        'amount',
        'fees',
        'request_date',
        'success_date',
        'cancel_date',
        'request_ip',
        'updated_by',
        'comments',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'merchant_account_id' => 'integer',
        'user_id'             => 'string',
        'accept_currency_id'  => 'integer',
        'wallet_id'           => 'string',
        'method'              => 'string',
        'amount'              => 'decimal:6',
        'fees'                => 'decimal:6',
        'request_date'        => 'date',
        'success_date'        => 'date',
        'cancel_date'         => 'date',
        'request_ip'          => 'string',
        'updated_by'          => 'integer',
        'comments'            => 'string',
        'status'              => MerchantWithdrawEnum::class,
    ];

    /**
     * Customer Information
     *
     * @return BelongsTo
     */
    public function merchantInfo(): BelongsTo
    {
        return $this->belongsTo(MerchantAccount::class, 'merchant_account_id');
    }

    /**
     * Customer Information
     * @return BelongsTo
     */
    public function coinInfo(): BelongsTo
    {
        return $this->belongsTo(AcceptCurrency::class, 'accept_currency_id', 'id');
    }

    public function withdrawalAccount(): BelongsTo
    {
        return $this->belongsTo(WithdrawalAccount::class, 'wallet_id', 'id');
    }

    /**
     * Currency Information
     *
     * @return BelongsTo
     */
    public function gatewayInfo(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class, 'method', 'id');
    }

    public function getCreatedAtAttribute($value): string
    {

        if ($value === null) {
            return 'N/A';
        } else {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        }

    }

    public function getUpdatedAtAttribute($value): string
    {

        if ($value === null) {
            return 'N/A';
        } else {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        }

    }

}
