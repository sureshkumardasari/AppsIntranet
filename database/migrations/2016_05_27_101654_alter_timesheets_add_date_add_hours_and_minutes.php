<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTimesheetsAddDateAddHoursAndMinutes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('time_sheets', function(Blueprint $table)
		{
			$table->date('date');
			$table->tinyInteger('hours')->default(0);
			$table->tinyInteger('minutes')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('time_sheets', function(Blueprint $table)
		{
			//
		});
	}

}
