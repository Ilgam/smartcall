<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'user_id',
        'task_id',
        'inn',
        'name',
        'type',
        'client',
        'address',
        'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
