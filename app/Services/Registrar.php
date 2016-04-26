<?php namespace App\Services;

use App\Department;
use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

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
  		$depart_name=$data['user_depart_name'];
		$depart_list = Department::where('name', '=', $data['user_depart_name'])->first();
   		return User::create([
			'username' => $data['username'],
			'department_id' => $depart_list['id'],
			'email' => $data['email'],
 			'first_name' => $data['first_name'],
 			'last_name' => $data['last_name'],
			'password' => bcrypt($data['password']),
 		]);
	}

}
