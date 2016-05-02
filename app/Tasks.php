<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model {

	//
    protected $table='tasks';
    protected $fillable=['project_id','user_id','module_id','task_title','task_description','date'];

}
