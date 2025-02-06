<?php

namespace Modules\B2xloan\App\Models;

use App\Models\AcceptCurrency;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class B2xLoanRepay extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "b2x_loan_id",
        "accept_currency_id",
        "amount",
        "customer_id",
        "method",
        "fees",
        "status",
    ];

    /**
     * Accept Currency
     *
     * @return BelongsTo
     */
    public function acceptCurrency(): BelongsTo
    {
        return $this->belongsTo(AcceptCurrency::class, 'accept_currency_id', 'id');
    }

    public function b2xLoan(): BelongsTo
    {
        return $this->belongsTo(B2xLoan::class, 'b2x_loan_id', 'id');
    }

    public function getCreatedAtAttribute($value): string
    {

        if ($value === null) {
            return '';
        } else {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        }

    }

    public function getUpdatedAtAttribute($value): string
    {

        if ($value === null) {
            return '';
        } else {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        }

    }

}
