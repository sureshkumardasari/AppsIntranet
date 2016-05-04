<?php
use Illuminate\Database\Seeder;

class UserDataSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();
		DB::table('users')->insert([
			'username' => 'Admin',
			'email' => 'admin@admin.com',
			'first_name' => 'Admin',
			'last_name' => '',
			'password' => '$2y$10$ObDTaepyaOPCFHvx33YRVuyvWco5yEMKQY8ErsTeiL/XOZCY55PFq',
			'status' => 'active',
			'role_id' => '1',
			'created_at' => new DateTime,
			'updated_at' => new DateTime,
   		]);
		DB::table('users')->insert([
			'username' => 'User',
			'email' => 'user@user.com',
			'first_name' => 'User',
			'last_name' => '',
			'password' => '$2y$10$ObDTaepyaOPCFHvx33YRVuyvWco5yEMKQY8ErsTeiL/XOZCY55PFq',
			'status' => 'active',
			'role_id' => '2',
			'created_at' => new DateTime,
			'updated_at' => new DateTime,
		]);
		DB::table('users')->insert([
			'username' => 'Project Lead',
			'email' => 'project@admin.com',
			'first_name' => 'Project',
			'last_name' => 'Lead',
			'password' => '$2y$10$ObDTaepyaOPCFHvx33YRVuyvWco5yEMKQY8ErsTeiL/XOZCY55PFq',
			'status' => 'active',
			'role_id' => '3',
			'created_at' => new DateTime,
			'updated_at' => new DateTime,
		]);
		DB::table('users')->insert([
			'username' => 'Project Manager',
			'email' => 'manager@admin.com',
			'first_name' => 'Project',
			'last_name' => 'Manager',
			'password' => '$2y$10$ObDTaepyaOPCFHvx33YRVuyvWco5yEMKQY8ErsTeiL/XOZCY55PFq',
			'status' => 'active',
			'role_id' => '4',
			'created_at' => new DateTime,
			'updated_at' => new DateTime,
		]);
  	}

}