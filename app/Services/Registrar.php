<?php namespace App\Services;

use App\Department;
use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use App\RoleUser;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'username' => 'required|max:255|unique:users',
			'first_name' => 'required|max:255',
			'last_name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
  		$depart_id=$data['user_depart_name'];
		dd($depart_id);
 		$roles_id=$data['roles'];
   		$user=User::create([
			'username' => $data['username'],
			'department_id' => $depart_id,
			'role_id' => $data['roles'],
			'email' => $data['email'],
 			'first_name' => $data['first_name'],
 			'last_name' => $data['last_name'],
			'password' => bcrypt($data['password']),
 		]);
		$roles=new RoleUser;
		$last_id=$user->id;
 		$roles->user_id=$last_id;
		$roles->role_id=$roles_id;
		$roles->timestamps = false;
		$roles->save();
		return $user;
	}

}
