<?php

namespace Modules\Merchant\App\Models;

use App\Models\FiatCurrency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Modules\Merchant\App\Enums\MerchantPaymentUlrPaymentTypeEnum;
use Modules\Merchant\App\Enums\MerchantPaymentUlrStatusEnum;

class MerchantPaymentUrl extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uu_id',
        'merchant_account_id',
        'title',
        'description',
        'payment_type',
        'amount',
        'fiat_currency_id',
        'calback_url',
        'message',
        'duration',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'uu_id'               => 'string',
        'merchant_account_id' => 'integer',
        'title'               => 'string',
        'description'         => 'string',
        'payment_type'        => MerchantPaymentUlrPaymentTypeEnum::class,
        'amount'              => 'string',
        'fiat_currency_id'    => 'integer',
        'calback_url'         => 'string',
        'message'             => 'string',
        'duration'            => 'datetime',
        'status'              => MerchantPaymentUlrStatusEnum::class,
    ];

    /**
     * The boot method to generate UUIDs for new records.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (empty($model->uuid)) {
                $model->uu_id = (string) Str::uuid();
            }

        });
    }

    /**
     * Fiat Currency
     *
     * @return BelongsTo
     */
    public function fiatCurrency(): BelongsTo
    {
        return $this->belongsTo(FiatCurrency::class);
    }

    /**
     * Merchant Accepted Coins
     *
     * @return HasMany
     */
    public function merchantAcceptedCoins(): HasMany
    {
        return $this->hasMany(MerchantAcceptedCoin::class);
    }

    /**
     * Merchant Accepted Coin
     *
     * @return HasOne
     */
    public function merchantAcceptedCoin(): HasOne
    {
        return $this->hasOne(MerchantAcceptedCoin::class);
    }

    /**
     * Merchant Account
     *
     * @return BelongsTo
     */
    public function merchantAccount(): BelongsTo
    {
        return $this->belongsTo(MerchantAccount::class, 'merchant_account_id');
    }

}
