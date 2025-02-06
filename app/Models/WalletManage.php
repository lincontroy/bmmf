<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletManage extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'accept_currency_id',
        'deposit',
        'credited',
        'roi_',
        'capital_return',
        'stake_earn',
        'referral',
        'received',
        'deposit_fee',
        'withdraw_fee',
        'transfer_fee',
        'withdraw',
        'investment',
        'transfer',
        'freeze_balance',
        'balance',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id'            => 'string',
        'accept_currency_id' => 'integer',
        'deposit'            => 'float',
        'credited'           => 'float',
        'roi_'               => 'float',
        'capital_return'     => 'float',
        'stake_earn'         => 'float',
        'referral'           => 'float',
        'received'           => 'float',
        'deposit_fee'        => 'float',
        'withdraw_fee'       => 'float',
        'transfer_fee'       => 'float',
        'withdraw'           => 'float',
        'investment'         => 'float',
        'transfer'           => 'float',
        'freeze_balance'     => 'float',
        'balance'            => 'float',
    ];

    public function customerInfo(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_id', 'user_id');
    }
}
