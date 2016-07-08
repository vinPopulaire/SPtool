<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeOfEnrichmentIdInEnrichmentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('enrichments', function(Blueprint $table)
		{
			$table->dropUnique("enrichments_enrichment_id_unique");
			$table->string("enrichment_id")->unique()->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('enrichments', function(Blueprint $table)
		{
			$table->dropUnique("enrichments_enrichment_id_unique");
			$table->integer("enrichment_id")->unique()->change();
		});
	}

}
