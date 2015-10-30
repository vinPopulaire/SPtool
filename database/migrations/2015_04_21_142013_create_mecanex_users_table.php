<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMecanexUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mecanex_users', function(Blueprint $table)
		{

				$table->increments('id');
				$table->integer('user_id')->unsigned();
				$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
				$table->string('username')->unique();
				$table->string('name');
				$table->string('surname');
				$table->integer('gender_id');
				$table->integer('age_id');
				$table->integer('education_id');
				$table->integer('occupation_id');
				$table->integer('country_id');
				//$table->string('facebook_account');
				//$table->string('twitter_account');
				$table->rememberToken();
				$table->timestamps();




			});//



	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mecanex_users');
	}

}
