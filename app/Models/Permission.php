<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Traits\WithCache;

class Permission extends SpatiePermission
{
    use HasFactory, WithCache;

    protected static $cacheKey = '__permission___';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'group',
        'guard_name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'name'       => 'string',
        'group'      => 'string',
        'guard_name' => 'string',
    ];
}
