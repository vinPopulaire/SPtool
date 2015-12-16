<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDcgsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dcgs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('mecanex_user_id');  //maybe this needs to refer to the mecanex users
			$table->string('video_id');
			$table->integer('rank');
			$table->integer('explicit_rf');
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
		Schema::drop('dcgs');
	}

}
