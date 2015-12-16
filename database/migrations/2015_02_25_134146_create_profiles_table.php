<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('profiles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('name');
			$table->string('surname');
			$table->integer('gender_id');
			$table->integer('age_id');
			$table->integer('education_id');
			$table->integer('occupation_id');
			$table->integer('country_id');
			$table->string('facebook_account');
			$table->string('twitter_account');
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
		//
		Schema::drop('profiles');
	}

}
