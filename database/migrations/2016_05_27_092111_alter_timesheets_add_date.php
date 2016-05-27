<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTimesheetsAddDate extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('time_sheets', function(Blueprint $table)
		{
			$table->dropColumn('hours');
			$table->dropColumn('minutes');

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
