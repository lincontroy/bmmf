<?php

namespace Modules\Finance\App\Models;

use App\Models\AcceptCurrency;
use App\Models\Customer;
use App\Models\PaymentGateway;
use App\Models\WithdrawalAccount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Finance\App\Enums\WithdrawStatusEnum;

class Withdrawal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'payment_gateway_id',
        'accept_currency_id',
        'withdrawal_account_id',
        'amount',
        'fees',
        'request_ip',
        'comments',
        'audited_by',
        'status',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'customer_id'           => 'integer',
        'payment_gateway_id'    => 'integer',
        'accept_currency_id'    => 'integer',
        'withdrawal_account_id' => 'integer',
        'amount'                => 'float',
        'fees'                  => 'float',
        'request_ip'            => 'string',
        'comments'              => 'string',
        'audited_by'            => 'integer',
        'status'                => WithdrawStatusEnum::class,
    ];

    /**
     * Cusomter Information
     *
     * @return BelongsTo
     */
    public function customerInfo(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Currency Information
     *
     * @return BelongsTo
     */
    public function currencyInfo(): BelongsTo
    {
        return $this->belongsTo(AcceptCurrency::class, 'accept_currency_id', 'id');
    }

    /**
     * Currency Information
     *
     * @return BelongsTo
     */
    public function gatewayInfo(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class, 'payment_gateway_id', 'id');
    }

    public function withdrawalAccount(): BelongsTo
    {
        return $this->belongsTo(WithdrawalAccount::class, 'withdrawal_account_id', 'id');
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
