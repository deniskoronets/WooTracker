<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
		'owner_id',
		'project_id',
		'name',
		'description',
		'assigned_id',
		'status_id',
    ];

    public function owner()
    {
        return $this->hasOne('App\Models\User', 'id', 'owner_id');
    }

 	public function assigned()
    {
        return $this->hasOne('App\Models\User', 'id', 'assigned_id');
    }

 	public function status()
    {
        return $this->hasOne('App\Models\Status', 'id', 'assigned_id');
    }

	public function project()
    {
        return $this->hasOne('App\Models\Project', 'id', 'project_id');
    }

    public function log()
    {
    	return $this->hasMany('App\Models\TaskLog', 'task_id', 'id');
    }

    public function lables()
    {
    	return $this->belongsToMany('App\Models\Label', 'task_label', 'task_id', 'label_id');
    }
}
