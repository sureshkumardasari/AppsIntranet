<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeSheetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('time_sheets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('project_id');
			$table->integer('module_id');
			$table->integer('task_id');
			$table->text('comment');
			$table->enum('status',[0,1,2,3]);
			$table->tinyInteger('hours')->unsigned;
			$table->tinyInteger('minutes')->unsigned;
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
		Schema::drop('time_sheets');
	}

}
