<?php

namespace Modules\Merchant\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Merchant\Database\factories\MechantAccountFactory;

class MechantAccount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): MechantAccountFactory
    {
        //return MechantAccountFactory::new();
    }
}
