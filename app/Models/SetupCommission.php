<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Package\App\Models\UserLevel;

class SetupCommission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'level_name',
        'personal_invest',
        'total_invest',
        'team_bonus',
        'referral_bonus',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'level_name'      => 'string',
        'personal_invest' => 'float',
        'total_invest'    => 'float',
        'team_bonus'     => 'float',
        'referral_bonus' => 'float',
    ];

    public function userLevel(): BelongsTo
    {
        return $this->belongsTo(UserLevel::class, 'level_name', 'level_id');
    }
}
