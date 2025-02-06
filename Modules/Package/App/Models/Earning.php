<?php

namespace Modules\Package\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Package\Database\factories\EarningFactory;

class Earning extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

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

    protected static function newFactory(): EarningFactory
    {
        //return EarningFactory::new();
    }
}
