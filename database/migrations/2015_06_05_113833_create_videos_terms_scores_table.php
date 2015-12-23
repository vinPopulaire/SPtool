<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTermsScoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videos_terms_scores', function(Blueprint $table)
		{
			$table->integer('video_id')->unsigned()->index();
			$table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade');
			$table->integer('term_id')->unsigned()->index();
			$table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
			$table->decimal('video_score',6,3);
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
		Schema::drop('videos_terms_scores');
	}

}
