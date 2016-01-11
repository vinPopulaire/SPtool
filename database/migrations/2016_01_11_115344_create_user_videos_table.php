<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserVideosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_video', function(Blueprint $table)
		{
			$table->integer('mecanex_user_id')->unsigned()->index();
			$table->foreign('mecanex_user_id')->references('id')->on('mecanex_users')->onDelete('cascade');
			$table->integer('video_id')->unsigned()->index();
			$table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade');
			$table->integer('seen');
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
		Schema::drop('user_videos');
	}

}
