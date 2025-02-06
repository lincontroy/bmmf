<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamMember extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'designation',
        'avatar',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name'        => 'string',
        'designation' => 'string',
        'avatar'      => 'string',
        'status'      => 'string',
    ];

    /**
     * Member Socials
     *
     * @return HasMany
     */
    public function memberSocials(): HasMany
    {
        return $this->hasMany(TeamMemberSocial::class);
    }
}
