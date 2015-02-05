<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowModule extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
//		Schema::create('workflows', function(Blueprint $table)
//		{
//			$table->increments('id');
//			$table->string('name');
//			$table->unsignedInteger('sprint_id')->index();
//			$table->foreign('sprint_id')->references('id')->on('sprints');
//		});


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
//		Schema::drop('workflows');
//		Schema::drop('task_statuses');
	}

}
