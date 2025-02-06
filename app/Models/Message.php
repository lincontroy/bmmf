<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'messenger_user_id',
        'user_id',
        'msg_subject',
        'msg_body',
        'msg_time',
        'replay_status',
        'msg_status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'messenger_user_id' => 'integer',
        'user_id'           => 'string',
        'msg_subject'       => 'string',
        'msg_body'          => 'string',
        'msg_time'          => 'datetime',
        'replay_status'     => 'string',
        'msg_status'        => 'string',
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
