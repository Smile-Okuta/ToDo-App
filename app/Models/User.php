<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; // Import JWTSubject

class User extends Authenticatable implements JWTSubject // Implement JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Implement the getJWTIdentifier method
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Implement the getJWTCustomClaims method
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function todoLists()
    {
        return $this->hasMany(TodoList::class);
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
