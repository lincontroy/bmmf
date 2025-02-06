<?php

namespace Modules\Stake\App\Models;

use App\Enums\StatusEnum;
use App\Models\AcceptCurrency;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class StakePlan extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'accept_currency_id',
        'stake_name',
        'status',
        'image',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'accept_currency_id' => 'integer',
        'stake_name'         => 'string',
        'status'             => StatusEnum::class,
        'image'              => 'string',
        'created_by'         => 'integer',
        'updated_by'         => 'integer',
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

    /**
     * Stake Rate Info
     *
     * @return HasMany
     */
    public function stakeRateInfo(): HasMany
    {
        return $this->hasMany(StakeRateInfo::class);
    }

    public function getCreatedAtAttribute($value): string
    {

        if ($value === null) {
            return '';
        } else {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        }

    }

}
