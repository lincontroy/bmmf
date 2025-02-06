<?php

namespace Modules\Merchant\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MerchantCustomerInfo extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'merchant_account_id',
        'email',
        'first_name',
        'last_name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'uuid'                => 'string',
        'merchant_account_id' => 'integer',
        'email'               => 'string',
        'first_name'          => 'string',
        'last_name'           => 'string',
    ];

    /**
     * The boot method to generate UUIDs for new records.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }

        });
    }

    /**
     * Merchant Account
     *
     * @return BelongsTo
     */
    public function merchantAccount(): BelongsTo
    {
        return $this->belongsTo(MerchantAccount::class, 'merchant_account_id');
    }

}
