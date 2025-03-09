<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const SKILL_Y = 1;
    public const SKILL_TBY = 2;
    public const SKILL_TB = 3;
    public const SKILL_TB_PLUS = 4;
    public const SKILL_TBK = 5;
    public const SKILL_K = 6;

    public const SKILL_LEVELS = [
        self::SKILL_Y => 'Y',
        self::SKILL_TBY => 'TBY',
        self::SKILL_TB => 'TB',
        self::SKILL_TB_PLUS => 'TB+',
        self::SKILL_TBK => 'TBK',
        self::SKILL_K => 'K',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
