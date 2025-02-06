<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Package\App\Models\Package;

class InvestmentRoi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    /**
     * currency
     *
     * @return BelongsTo
     */
    public function investment(): BelongsTo
    {
        return $this->belongsTo(Investment::class, 'investment_id', 'id');
    }


}
