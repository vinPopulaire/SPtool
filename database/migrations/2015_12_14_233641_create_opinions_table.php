<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpinionsTable extends Migration {

	/**
	 * created to store the opinion users have for their profiles for the online experiments
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('opinions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('mecanex_user_id')->unsigned()->index();
			$table->foreign('mecanex_user_id')->references('id')->on('mecanex_users')->onDelete('cascade');
			$table->integer('opinion');
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
		Schema::drop('opinions');
	}

}
