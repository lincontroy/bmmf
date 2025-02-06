<?php

namespace Modules\B2xloan\App\Models;

use App\Models\AcceptCurrency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class B2xCurrency extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "accept_currency_id",
        "price",
        "status",
        "default_coin",
    ];

    protected $casts = [
        "price"  => "float",
        "status" => StatusEnum::class,
    ];

    public function b2xLoanRepay(): BelongsTo
    {
        return $this->belongsTo(B2xLoanRepay::class);
    }

    /**
     * Summary of acceptCurrency
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function acceptCurrency(): BelongsTo
    {
        return $this->belongsTo(AcceptCurrency::class, 'accept_currency_id', 'id');
    }

}