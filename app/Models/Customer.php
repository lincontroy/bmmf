<?php

namespace App\Models;

use App\Enums\CustomerMerchantVerifyStatusEnum;
use App\Enums\CustomerStatusEnum;
use App\Enums\CustomerVerifyStatusEnum;
use App\Enums\SiteAlignEnum;
use App\Models\CustomerVerifyDoc;
use App\Traits\ActionButtonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Merchant\App\Enums\MerchantApplicationStatusEnum;
use Modules\Merchant\App\Models\MerchantAccount;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, ActionButtonTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'username',
        'email',
        'email_verified_at',
        'email_verification_token',
        'password',
        'phone',
        'site_align',
        'google2fa_secret',
        'google2fa_enable',
        'referral_user',
        'language',
        'country',
        'city',
        'state',
        'address',
        'avatar',
        'status',
        'verified_status',
        'merchant_verified_status',
        'visitor',
        'last_login',
        'last_logout',
        'created_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'password_reset_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id'                  => 'string',
        'first_name'               => 'string',
        'last_name'                => 'string',
        'username'                 => 'string',
        'email'                    => 'string',
        'email_verified_at'        => 'datetime',
        'email_verification_token' => 'string',
        'password'                 => 'hashed',
        'phone'                    => 'string',
        'google2fa_secret'         => 'string',
        'google2fa_enable'         => 'boolean',
        'referral_user'            => 'string',
        'language'                 => 'string',
        'country'                  => 'string',
        'city'                     => 'string',
        'state'                    => 'string',
        'address'                  => 'string',
        'avatar'                   => 'string',
        'status'                   => CustomerStatusEnum::class,
        'verified_status'          => CustomerVerifyStatusEnum::class,
        'site_align'               => SiteAlignEnum::class,
        'merchant_verified_status' => CustomerMerchantVerifyStatusEnum::class,
        'visitor'                  => 'string',
        'last_login'               => 'datetime',
        'last_logout'              => 'datetime',
    ];

    /**
     * Customer doc info
     *
     * @return HasOne
     */
    public function customerDocs(): HasOne
    {
        return $this->hasOne(CustomerVerifyDoc::class);
    }

    /**
     * Approved Merchant Account
     *
     * @return HasOne
     */
    public function approvedMerchantAccount(): HasOne
    {
        return $this->hasOne(MerchantAccount::class, 'user_id', 'user_id')
            ->where('status', MerchantApplicationStatusEnum::APPROVED->value);
    }

    public function investments(): HasMany
    {
        return $this->hasMany(Investment::class, 'user_id', 'user_id');
    }

    public function sponsoredUsers(): HasMany
    {
        return $this->hasMany(Customer::class, 'referral_user', 'user_id');
    }

    /**
     * Notifications of customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'customer_id');
    }
}
