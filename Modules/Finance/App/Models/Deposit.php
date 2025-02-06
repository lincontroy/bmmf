<?php

namespace Modules\Finance\App\Models;

use App\Models\AcceptCurrency;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Finance\App\Enums\DepositEnum;
use Modules\Finance\Database\factories\DepositFactory;

class Deposit extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'accept_currency_id',
        'user_id',
        'date',
        'method',
        'amount',
        'fees',
        'stripe_session_id',
        'comments',
        'deposit_ip',
        'updated_by',
        'status',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'customer_id'        => 'integer',
        'accept_currency_id' => 'integer',
        'user_id'            => 'string',
        'date'               => 'date',
        'method'             => 'string',
        'amount'             => 'float',
        'fees'               => 'float',
        'stripe_session_id'  => 'string',
        'comments'           => 'string',
        'deposit_ip'         => 'string',
        'status'             => DepositEnum::class,
    ];

    protected static function newFactory(): DepositFactory
    {
        return DepositFactory::new ();
    }

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

    public function getCreatedAtAttribute($value): string
    {

        if ($value === null) {
            return 'N/A';
        } else {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        }

    }

}
