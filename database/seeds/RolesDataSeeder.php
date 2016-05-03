<?php
use Illuminate\Database\Seeder;

class RolesDataSeeder extends Seeder {

	public function run()
	{
		DB::table('roles')->delete();
		DB::table('roles')->insert([
			'id' => '1',
			'name' => 'Admin',
			'display_name' => 'Admin',
			'description' =>'Admin User',
			'created_at' => new DateTime,
			'updated_at' => new DateTime,
		]);
		DB::table('roles')->insert([
			'id' => '2',
			'name' => 'User',
			'display_name' => 'User',
			'description' =>'user',
			'created_at' => new DateTime,
			'updated_at' => new DateTime,
		]);
		DB::table('roles')->insert([
			'id' => '3',
			'name' => 'Project Lead',
			'display_name' => 'Project Lead',
			'description' =>'Project Lead User',
			'created_at' => new DateTime,
			'updated_at' => new DateTime,
		]);
		DB::table('roles')->insert([
			'id' => '4',
			'name' => 'Project Manager',
			'display_name' => 'Project Manager',
			'description' =>'Project Manager User',
			'created_at' => new DateTime,
			'updated_at' => new DateTime,
		]);
  	}

}