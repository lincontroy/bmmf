<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleLangData extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id',
        'language_id',
        'slug',
        'small_content',
        'large_content',
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
        'article_id'    => 'integer',
        'language_id'   => 'integer',
        'slug'          => 'string',
        'small_content' => 'string',
        'large_content' => 'string',
        'status'        => 'string',
        'created_by'    => 'integer',
        'updated_by'    => 'integer',
    ];

    /**
     * Article
     *
     * @return BelongsTo
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Language
     *
     * @return BelongsTo
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    
     /**
     * createtor info
     *
     * @return BelongsTo
     */
    public function creatorInfo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

}
