<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function roles(){
        return $this->belongsToMany(Role::class,'user_roles');
    }

    public function authorizeRoles($roles)

    {

        if ($this->hasAnyRole($roles)) {

            return true;

        }

        abort(401, 'Non authorized action.');

    }

    public function hasAnyRole($roles)

    {

        if (is_array($roles)) {

            foreach ($roles as $role) {

                if ($this->hasRole($role)) {

                    return true;

                }

            }

        } else {

            if ($this->hasRole($roles)) {

                return true;

            }

        }

        return false;

    }

    public function hasRole($role)

    {

        if ($this->roles()->where('name', $role)->first()) {

            return true;

        }

        return false;

    }
}
