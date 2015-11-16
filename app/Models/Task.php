<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TaskLabel;
use App\Models\Label;

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

    public function comments()
    {
    	return $this->hasMany('App\Models\TaskComment', 'task_id', 'id');
    }

    public function labels()
    {
    	return $this->belongsToMany('App\Models\Label', 'task_label', 'task_id', 'label_id');
    }

    public function hasLabel(Label $label)
    {
    	return TaskLabel::where('task_id', '=', $this->id)
    					->where('label_id', '=', $label->id)
    					->count() > 0;
    }
}
