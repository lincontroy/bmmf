<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Modules\B2xloan\App\Models\B2xCurrency;
use Modules\Merchant\App\Models\MerchantFee;

class AcceptCurrency extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'symbol',
        'logo',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name'       => 'string',
        'symbol'     => 'string',
        'logo'       => 'string',
        'status'     => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * Merchant Fee Information
     *
     */
    public function marchentAcceptCoinInfo(): HasOne
    {
        return $this->hasOne(MerchantFee::class, 'accept_currency_id');
    }

    public function b2xCurrency(): HasOne
    {
        return $this->hasOne(B2xCurrency::class, 'accept_currency_id', 'id');
    }

    public function currencyGateway(): HasMany
    {
        return $this->hasMany(AcceptCurrencyGateway::class);
    }

    public function getCreatedAtAttribute($value): string
    {

        if ($value === null) {
            return 'N/A';
        } else {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        }

    }

    public function getBalance(): HasOne
    {
        return $this->hasOne(WalletManage::class, 'accept_currency_id', 'id');
    }

}
