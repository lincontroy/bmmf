<?php

namespace App\Models;

use App\Enums\NotificationEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        "customer_id",
        "notification_type",
        "subject",
        "details",
        "status",
        'created_at',
    ];

    protected $casts = [
        "customer_id"       => "integer",
        "notification_type" => "string",
        "subject"           => "string",
        "details"           => "string",
        "status"            => NotificationEnum::class,
    ];

    /**
     * Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
