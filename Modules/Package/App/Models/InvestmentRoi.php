<?php

namespace Modules\Package\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentRoi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "investment_id",
        "user_id",
        "roi_amount",
        "received_at",
    ];

    protected $casts = [
        "investment_id" => "integer",
        "user_id"       => "string",
        "roi_amount"    => "decimal:4",
        "received_at"   => "datetime",
    ];
}
