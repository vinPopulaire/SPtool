<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrichmentsTermsScoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enrichments_terms_scores', function(Blueprint $table)
		{
			$table->integer('enrichment_id')->unsigned()->index();
			$table->foreign('enrichment_id')->references('id')->on('enrichments')->onDelete('cascade');
			$table->integer('term_id')->unsigned()->index();
			$table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
			$table->decimal('enrichment_score',6,3);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('enrichments_terms_scores');
	}

}
