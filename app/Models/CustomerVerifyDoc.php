<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Enums\CustomerDocumentTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerVerifyDoc extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'user_id',
        'verify_type',
        'first_name',
        'last_name',
        'gender',
        'country',
        'state',
        'city',
        'document_type',
        'id_number',
        'expire_date',
        'document1',
        'document2',
        'document3',
    ];

    protected $casts = [
        'customer_id'   => 'integer',
        'user_id'       => 'string',
        'verify_type'   => 'string',
        'first_name'    => 'string',
        'last_name'     => 'string',
        'gender'        => GenderEnum::class,
        'country'       => 'string',
        'state'         => 'string',
        'city'          => 'string',
        'document_type' => CustomerDocumentTypeEnum::class,
        'id_number'     => 'string',
        'expire_date'   => 'date',
        'document1'     => 'string',
        'document2'     => 'string',
        'document3'     => 'string',
    ];

}
