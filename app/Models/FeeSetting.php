<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\FeeSettingLevelEnum;

class FeeSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'level',
        'fee',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'level'      => FeeSettingLevelEnum::class,
        'fee'        => 'float',
        'status'     => 'string',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];
}
