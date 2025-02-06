<?php

namespace Modules\Merchant\App\Models;

use App\Models\AcceptCurrency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Merchant\App\Models\MerchantPaymentInfo;

class MerchantAcceptedCoin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'accept_currency_id',
        'merchant_payment_url_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'accept_currency_id'      => 'integer',
        'merchant_payment_url_id' => 'integer',
    ];

    /**
     * Accept Currency
     *
     * @return BelongsTo
     */
    public function acceptCurrency(): BelongsTo
    {
        return $this->belongsTo(AcceptCurrency::class, 'accept_currency_id');
    }

    /**
     * Accept Currency
     *
     * @return HasOne
     */
    public function acceptedCurrency(): HasOne
    {
        return $this->hasOne(AcceptCurrency::class);
    }

    /**
     * Merchant Payment Info
     *
     * @return HasOne
     */
    public function merchantPaymentInfo(): HasOne
    {
        return $this->hasOne(MerchantPaymentInfo::class);
    }

    /**
     * Merchant Payment Infos
     *
     * @return HasMany
     */
    public function merchantPaymentInfos(): HasMany
    {
        return $this->hasMany(MerchantPaymentInfo::class);
    }
}
