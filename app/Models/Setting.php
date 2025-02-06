<?php

namespace App\Models;

use App\Enums\SiteAlignEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'email',
        'phone',
        'logo',
        'logo_web',
        'login_bg_img',
        'favicon',
        'language_id',
        'site_align',
        'footer_text',
        'latitude_longitude',
        'time_zone',
        'office_time',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'title'              => 'string',
        'description'        => 'string',
        'email'              => 'string',
        'phone'              => 'string',
        'logo'               => 'string',
        'logo_web'           => 'string',
        'favicon'            => 'string',
        'language_id'        => 'integer',
        'site_align'         => SiteAlignEnum::class,
        'footer_text'        => 'string',
        'latitude_longitude' => 'string',
        'time_zone'          => 'string',
        'office_time'        => 'string',
        'updated_at'         => 'datetime',
    ];

    /**
     * Get Logo url
     *
     * @return string|null
     */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? storage_asset($this->logo) : null;
    }

    /**
     * Get Favicon url
     *
     * @return string|null
     */
    public function getFaviconUrlAttribute(): ?string
    {
        return $this->favicon ? storage_asset($this->favicon) : null;
    }

    /**
     * Language
     *
     * @return BelongsTo
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
