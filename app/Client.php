<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

	protected $table = 'clients';

	protected $fillable = ['clientname','email','phone1','phone2','fax','skypeid','address'];

	protected $hidden = ['remember_token'];

}
