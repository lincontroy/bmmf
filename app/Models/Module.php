<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'module_name',
        'created_by',
        'updated_by',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'module_name' => 'string',
        'status'      => 'boolean',
        'created_by'  => 'integer',
        'updated_by'  => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];
}
