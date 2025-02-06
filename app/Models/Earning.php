<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Earning extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'customer_id',
        'earning_type',
        'package_id',
        'investment_id',
        'date',
        'amount',
        'comments',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id'       => 'string',
        'customer_id'   => 'integer',
        'earning_type'  => 'string',
        'package_id'    => 'integer',
        'investment_id' => 'integer',
        'date'          => 'date',
        'amount'        => 'float',
        'comments'      => 'string',
    ];

    /**
     * currency
     *
     * @return BelongsTo
     */
    public function investment(): BelongsTo
    {
        return $this->belongsTo(Investment::class, 'investment_id', 'id');
    }
}
