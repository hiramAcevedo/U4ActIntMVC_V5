<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

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

    /**
     * Get the files for the user.
     */
    public function files()
    {
        return $this->hasMany(UserFile::class);
    }

    /**
     * Get only the image files for the user.
     */
    public function images()
    {
        return $this->hasMany(UserFile::class)->where('is_image', true);
    }

    /**
     * Get only the document files for the user.
     */
    public function documents()
    {
        return $this->hasMany(UserFile::class)->where('is_image', false);
    }

    /**
     * Get the favorite files for the user.
     */
    public function favorites()
    {
        return $this->hasMany(UserFile::class)->where('is_favorite', true);
    }
}
