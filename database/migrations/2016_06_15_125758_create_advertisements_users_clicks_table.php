<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementsUsersClicksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('advertisements_users_clicks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('mecanex_user_id')->unsigned()->index();
			$table->foreign('mecanex_user_id')->references('id')->on('mecanex_users')->onDelete('cascade');
			$table->string('content_id');
			$table->integer('clicks');
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
		Schema::drop('advertisements_users_clicks');
	}

}
