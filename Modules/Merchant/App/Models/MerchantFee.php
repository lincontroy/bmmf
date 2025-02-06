<?php

namespace Modules\Merchant\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Merchant\Database\factories\MerchantFeeFactory;

class MerchantFee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'accept_currency_id',
        'percent',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'accept_currency_id' => 'integer',
    ];

    protected static function newFactory(): MerchantFeeFactory
    {
        return MerchantFeeFactory::new();
    }

}
