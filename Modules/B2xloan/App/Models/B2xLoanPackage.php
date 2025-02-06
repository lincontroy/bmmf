<?php

namespace Modules\B2xloan\App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\B2xloan\Database\factories\B2xLoanPackageFactory;

class B2xLoanPackage extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'no_of_month',
        'interest_percent',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'no_of_month' => 'integer',
        'interest_percent' => 'string',
        'status' => StatusEnum::class,
    ];

    protected static function newFactory(): B2xLoanPackageFactory
    {
        return B2xLoanPackageFactory::new();
    }
}
