<?php

namespace Modules\Package\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Package\Database\factories\TeamBonusFactory;

class TeamBonus extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
//    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'sponsor_commission',
        'team_commission',
        'level',
        'last_update',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id'            => 'string',
        'name'               => 'string',
        'sponsor_commission' => 'float',
        'team_commission'    => 'float',
        'last_update'        => 'date',
    ];

    protected static function newFactory(): TeamBonusFactory
    {
        //return TeamBonusFactory::new();
    }
}
