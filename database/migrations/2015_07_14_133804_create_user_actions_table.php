<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserActionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_actions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username');
			$table->string('device_id');
			$table->string('video_id');
			$table->integer('action');
			$table->string('content_id');
			$table->string('time');
			$table->integer('explicit_rf');
			$table->decimal('weight',4,2);  //used for the weight of action e.g. share on enrichments = 1
			$table->decimal('importance',4,2);  //used for giving the importance of the relevance feedback factor
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
		Schema::drop('user_actions');
	}

}
