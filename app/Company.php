<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
//    protected $table = 'my_flights';

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
