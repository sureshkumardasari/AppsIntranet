<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDepartments extends Model {

    protected $table = 'user_departments';
    protected $fillable=['user_id','depart_id'];

}
