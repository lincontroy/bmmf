<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'article_name',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'slug'         => 'string',
        'article_name' => 'string',
        'status'       => 'string',
    ];

    /**
     * Article Data
     *
     * @return HasMany
     */
    public function articleData(): HasMany
    {
        return $this->hasMany(ArticleData::class);
    }

    /**
     * Article Lang Data
     *
     * @return HasMany
     */
    public function articleLangData(): HasMany
    {
        return $this->hasMany(ArticleLangData::class);
    }

}
