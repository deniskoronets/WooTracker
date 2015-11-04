<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    protected $table = 'tasks_log';
    protected $fillable = ['task_id', 'description', 'log_date'];
    public $timestamps = false;
}
