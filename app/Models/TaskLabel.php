<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLabel extends Model
{
  	protected $table = 'task_label';
  	public $timestamps = false;

  	protected $fillable = [
		'task_id',
		'label_id',
    ];

}
