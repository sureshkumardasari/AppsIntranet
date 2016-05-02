<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_modules', function(Blueprint $table)
		{
				$table->increments('id');
				$table->string('name');
				$table->string('description');
				$table->integer('project_id');
				$table->timestamps();
 		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('project_modules');
	}

}
