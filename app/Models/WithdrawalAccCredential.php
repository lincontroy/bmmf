<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalAccCredential extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'withdrawal_account_id',
        'type',
        'name',
        'credential',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'withdrawal_account_id' => "integer",
        'type'                  => 'string',
        'name'                  => 'string',
        'credential'            => 'string',
    ];
}
