<?php

namespace App\Models;

use App\Enums\UserLogTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'access_time',
        'user_agent',
        'user_ip',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'string',
        'type' => UserLogTypeEnum::class,
        'access_time' => 'date',
        'user_agent' => 'string',
        'user_ip' => 'string',
    ];

    /**
     * currency
     *
     * @return BelongsTo
     */
    public function customerInfo(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_id', 'user_id');
    }
}
