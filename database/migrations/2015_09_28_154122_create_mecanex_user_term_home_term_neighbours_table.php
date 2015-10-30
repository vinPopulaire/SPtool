<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMecanexUserTermHomeTermNeighboursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mecanex_user_term_home_term_neighbours', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('mecanex_user_id')->unsigned()->index();
			$table->foreign('mecanex_user_id')->references('id')->on('mecanex_users')->onDelete('cascade');
			$table->integer('term_home_id')->unsigned()->index();
			$table->foreign('term_home_id')->references('id')->on('terms')->onDelete('cascade');
			$table->integer('term_neighbor_id')->unsigned()->index();
			$table->foreign('term_neighbor_id')->references('id')->on('terms')->onDelete('cascade');
			$table->decimal('link_score',6,3);
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
		Schema::drop('mecanex_user_term_home_term_neighbours');
	}

}
