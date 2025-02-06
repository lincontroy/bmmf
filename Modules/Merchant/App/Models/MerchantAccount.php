<?php

namespace Modules\Merchant\App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Merchant\App\Enums\MerchantApplicationStatusEnum;
use Modules\Merchant\Database\factories\MerchantAccountFactory;

class MerchantAccount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'store_name',
        'about',
        'email',
        'phone',
        'website_url',
        'logo',
        'checker_note',
        'checked_by',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id'      => 'string',
        'store_name'   => 'string',
        'about'        => 'string',
        'email'        => 'string',
        'phone'        => 'string',
        'website_url'  => 'string',
        'logo'         => 'string',
        'checker_note' => 'string',
        'checked_by'   => 'string',
        'status'       => MerchantApplicationStatusEnum::class,
    ];


    /**
     * Cusomter Information
     *
     * @return BelongsTo
     */
    public function customerInfo(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_id', 'user_id');
    }
}
