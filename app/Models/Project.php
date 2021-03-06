<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
 	public $timestamps = false;
 	protected $fillable = ['owner_id', 'name', 'created_date'];

    public function owner()
    {
        return $this->hasOne('App\Models\User', 'id', 'owner_id');
    }

}
