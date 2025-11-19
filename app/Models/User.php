<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{

    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function is_super_admin()
    {
        return $this->role == 'super_admin';
    }

    public function is_admin() {
        return $this->role == 'admin' || $this->role == 'super_admin';
    }

    public function is_user() {
        return $this->role == 'user';
    }

    public function terms() {
        return $this->hasMany(Term::class);
    }

}
