<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempProfilescores extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('temp_profilescores', function(Blueprint $table)
		{
			$table->integer('id')->unsigned()->index();
			$table->integer('term_id')->unsigned()->index();
			$table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
			$table->decimal('profile_score',6,3);
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
		Schema::drop('temp_profilescores');
	}


}
