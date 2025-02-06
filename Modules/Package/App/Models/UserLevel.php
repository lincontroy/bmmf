<?php

namespace Modules\Package\App\Models;

use App\Models\SetupCommission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Package\Database\factories\UserLevelsFactory;

class UserLevel extends Model
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
        'level_id',
        'achieve_date',
        'bonus',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id'     => 'string',
        'level_id'    => 'integer',
        'achieve_date' => 'date',
        'bonus'       => 'float',
        'status'      => 'integer',
    ];

    protected static function newFactory(): UserLevelsFactory
    {
        //return UserLevelsFactory::new();
    }

    public function setupCommission(): HasMany
    {
        return $this->hasMany(SetupCommission::class, 'level_name', 'level_id');
    }
}
