<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class projectModules extends Model {

	//
protected $table='project_modules';
    protected $fillable=['name','description','project_id'];
}
