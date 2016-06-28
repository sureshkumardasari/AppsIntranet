<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectModules extends Model {

	//
protected $table='project_modules';
    protected $fillable=['name','description','project_id'];
}
