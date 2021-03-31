<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'is_manager',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Returns list of the permissions for the user
     */
    public function permissions()
    {
        return $this->hasMany(UserPermission::class);
    }

    /**
     * Checks a user has a permission
     *
     * @param string $permission
     * @return bool
     */
    public function has_permission(string $permission): bool
    {
        if ($this->is_manager) {
            // The manager user has all the permissions
            return true;
        }

        return $this->permissions()->where('name', $permission)->count() > 0;
    }
}
