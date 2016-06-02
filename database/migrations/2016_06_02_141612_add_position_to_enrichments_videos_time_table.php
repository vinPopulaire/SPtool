<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPositionToEnrichmentsVideosTimeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('enrichments_videos_time', function(Blueprint $table)
		{
			$table->decimal('height',6,2);
			$table->decimal('width',6,2);
			$table->decimal('x_min',6,2);
			$table->decimal('y_min',6,2);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('enrichments_videos_time', function(Blueprint $table)
		{
			$table->dropColumn('height');
			$table->dropColumn('width');
			$table->dropColumn('x_min');
			$table->dropColumn('y_min');
		});
	}

}
