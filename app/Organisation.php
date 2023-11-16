<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    protected $fillable = [
        'name', 'uniqid'
    ];
    // Define relationships
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function todoItems()
    {
        return $this->hasMany(TodoItem::class);
    }
}
