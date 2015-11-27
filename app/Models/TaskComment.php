<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    protected $table = 'tasks_comments';

    protected $fillable = [
		'owner_id',
		'task_id',
		'description',
    ];

    public function owner()
    {
        return $this->hasOne('App\Models\User', 'id', 'owner_id');
    }
}
