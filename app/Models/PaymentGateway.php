<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentGateway extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'min_deposit',
        'max_deposit',
        'fee_percent',
        'logo',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'name'        => 'string',
        'min_deposit' => 'float',
        'max_deposit' => 'float',
        'fee_percent' => 'float',
        'logo'        => 'string',
        'status'      => 'string',
        'created_by'  => 'integer',
        'updated_by'  => 'integer',
    ];

    public function credential(): HasMany
    {
        return $this->hasMany(PaymentGatewayCredential::class);
    }
}
