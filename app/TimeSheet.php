<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model {

	//
protected $table='time_sheets';
  protected  $fillable=['project_id','user_id','module_id','task_id','comment','status','hours','minutes'];
}
