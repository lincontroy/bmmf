<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserIsAdminEnum;
use App\Enums\UserStatusEnum;
use App\Traits\ActionButtonTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, ActionButtonTrait, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'about',
        'email',
        'password',
        'remember_token',
        'image',
        'last_login',
        'last_logout',
        'ip_address',
        'status',
        'is_admin',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'password_reset_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'first_name'        => 'string',
        'last_name'         => 'string',
        'about'             => 'string',
        'email'             => 'string',
        'password'          => 'hashed',
        'image'             => 'string',
        'last_login'        => 'datetime',
        'last_logout'       => 'datetime',
        'ip_address'        => 'string',
        'status'            => UserStatusEnum::class,
        'is_admin'          => UserIsAdminEnum::class,
        'created_by'        => 'integer',
        'updated_by'        => 'integer',
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get Logo url
     *
     * @return string|null
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? storage_asset($this->image) : null;
    }

    /**
     * Name attribute
     *
     * @return void
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     *  creator info
     *
     * @return BelongsTo
     */
    public function articleLangData(): BelongsTo
    {
        return $this->belongsTo(ArticleLangData::class, 'created_by', 'id');
    }

}
