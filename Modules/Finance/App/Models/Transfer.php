<?php

namespace Modules\Finance\App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Finance\App\Enums\TransferStatusEnum;

class Transfer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'sender_user_id',
        'receiver_user_id',
        'currency_symbol',
        'amount',
        'fees',
        'date',
        'request_ip',
        'comments',
        'status',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'sender_user_id'   => 'string',
        'receiver_user_id' => 'string',
        'date'             => 'date',
        'currency_symbol'  => 'string',
        'amount'           => 'decimal:2',
        'fees'             => 'decimal:2',
        'comments'         => 'string',
        'request_ip'       => 'string',
        'status'           => TransferStatusEnum::class,
    ];

    /**
     * Sender Information
     *
     * @return BelongsTo
     */
    public function senderInformation(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'sender_user_id', 'user_id');
    }

    /**
     * Recever Information
     *
     * @return BelongsTo
     */
    public function receiverInformation(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'receiver_user_id', 'user_id');
    }

    public function getCreatedAtAttribute($value): string
    {

        if ($value === null) {
            return 'N/A';
        } else {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        }

    }

}
