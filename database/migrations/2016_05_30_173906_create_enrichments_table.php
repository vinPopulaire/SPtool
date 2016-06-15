<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrichmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enrichments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('enrichment_id')->unique();
			$table->string('class');
            $table->string('longName');
            $table->string('dbpediaURL');
            $table->string('wikipediaURL');
            $table->text('description');
            $table->string('thumbnail');
			$table->timestamps();
		});

        DB::statement('ALTER TABLE enrichments ADD FULLTEXT search(class, longName, description)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('enrichments');
	}

}
