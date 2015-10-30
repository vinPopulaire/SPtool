<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersInterestsScoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_interests_scores', function(Blueprint $table)
		{
			$table->integer('mecanex_user_id')->unsigned()->index();
			$table->foreign('mecanex_user_id')->references('id')->on('mecanex_users')->onDelete('cascade');
			$table->integer('interest_id')->unsigned()->index();
			$table->foreign('interest_id')->references('id')->on('interests')->onDelete('cascade');
			$table->integer('interest_score');
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
		Schema::drop('users_interests_scores');
	}

}
