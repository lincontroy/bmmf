<?php

namespace App\Models;

use App\Models\AcceptCurrency;
use App\Models\Customer;
use App\Models\PaymentGateway;
use App\Models\WithdrawalAccCredential;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawalAccount extends Model
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
        'payment_gateway_id',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'customer_id'        => "integer",
        'payment_gateway_id' => 'integer',
        'accept_currency_id' => 'integer',
        'status'             => 'string',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(AcceptCurrency::class, 'accept_currency_id', 'id');
    }

    public function credentials(): HasMany
    {
        return $this->hasMany(WithdrawalAccCredential::class);
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class, 'payment_gateway_id', 'id');
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
