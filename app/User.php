<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Define relationships
    public function organisations()
    {
        return $this->belongsToMany(Organisation::class);
    }

    public function todoItems()
    {
        return $this->hasMany(TodoItem::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
        // You might have a different way of determining admin status,
        // such as checking for a specific role in a roles table.
    }
}
