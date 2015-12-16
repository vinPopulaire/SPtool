<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('video_id')->unique();
			$table->string('genre');
			$table->string('topic');
			$table->string('geographical_coverage');
			$table->string('thesaurus_terms');
			$table->string('title');
			$table->string('local_keywords');
			$table->text('summary');
			$table->timestamps();
		});
		DB::statement('ALTER TABLE videos ADD FULLTEXT search(genre, topic, geographical_coverage, thesaurus_terms, title)');

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('videos', function($table) {
			$table->dropIndex('search');
        });

		Schema::drop('videos');
	}

}
