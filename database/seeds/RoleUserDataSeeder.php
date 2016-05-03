<?php
use Illuminate\Database\Seeder;

class RoleUserDataSeeder extends Seeder {

	public function run()
	{
		DB::table('role_user')->delete();
		DB::table('role_user')->insert([
			'user_id' => '1',
			'role_id' => '1',
   		]);
		DB::table('role_user')->insert([
			'user_id' => '2',
			'role_id' => '2',
		]);
		DB::table('role_user')->insert([
			'user_id' => '3',
			'role_id' => '3',
		]);
		DB::table('role_user')->insert([
			'user_id' => '4',
			'role_id' => '4',
		]);
  	}

}