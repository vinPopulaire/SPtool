<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrichmentsVideosTimeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enrichments_videos_time', function(Blueprint $table)
		{
			$table->integer('enrichment_id')->unsigned()->index();
			$table->foreign('enrichment_id')->references('id')->on('enrichments')->onDelete('cascade');
			$table->integer('video_id')->unsigned()->index();
			$table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade');
			$table->integer('time');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('enrichments_videos_time');
	}

}
