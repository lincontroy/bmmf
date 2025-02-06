<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGatewayCredential extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'payment_gateway_id',
        'type',
        'name',
        'credentials',
    ];

    /**
     * The attributes that should be cast.
     * @var array
     */
    protected $casts = [
        'type'        => 'string',
        'name'        => 'string',
        'credentials' => 'string',
    ];
}
