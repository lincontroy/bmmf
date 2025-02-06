<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Package\App\Enums\CapitalReturnStatusEnum;

class CapitalReturn extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'investment_id',
        'user_id',
        'return_amount',
        'status',
        'return_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'investment_id' => 'integer',
        'user_id'       => 'string',
        'return_amount' => 'integer',
        'status'        => CapitalReturnStatusEnum::class,
        'return_at'     => 'date',
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
