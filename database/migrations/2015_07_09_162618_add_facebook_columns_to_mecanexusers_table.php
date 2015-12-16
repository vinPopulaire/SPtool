<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFacebookColumnsToMecanexusersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('mecanex_users', function(Blueprint $table)
		{
			$table->bigInteger('facebook_user_id')->unsigned()->index();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('mecanex_users', function(Blueprint $table)
		{

			$table->dropColumn(
				'facebook_user_id'
							);

		});
	}

}
