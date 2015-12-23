<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersDcgTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_dcg', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('mecanex_user_id');  //maybe this needs to refer to the mecanex users
			$table->decimal('dcg',4,2);
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
		Schema::drop('users_dcg');
	}

}
