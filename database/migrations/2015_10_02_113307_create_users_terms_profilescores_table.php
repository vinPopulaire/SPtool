<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTermsProfilescoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_terms_profilescores', function(Blueprint $table)
		{
			$table->integer('mecanex_user_id')->unsigned()->index();
			$table->foreign('mecanex_user_id')->references('id')->on('mecanex_users')->onDelete('cascade');
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
		Schema::drop('users_terms_profilescores');
	}

}
