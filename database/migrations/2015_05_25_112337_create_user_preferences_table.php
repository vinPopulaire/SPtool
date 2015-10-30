<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPreferencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_preferences', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('mecanex_user_id')->unique()->unsigned();
			$table->foreign('mecanex_user_id')->references('id')->on('mecanex_users')->onDelete('cascade');
			$table->string('arts');
			$table->string('disasters');
			$table->string('education');
			$table->string('environment');
			$table->string('health');
			$table->string('lifestyle');
			$table->string('media');
			$table->string('holidays');
			$table->string('politics');
			$table->string('religion');
			$table->string('society');
			$table->string('transportation');
			$table->string('wars');
			$table->string('work');
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
		Schema::drop('user_preferences');
	}

}


