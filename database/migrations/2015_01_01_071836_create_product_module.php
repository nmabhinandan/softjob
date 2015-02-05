<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductModule extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
//		Schema::create('products', function(Blueprint $table)
//		{
//			$table->increments('id');
//			$table->string('name')->index();
//			$table->string('slug')->unique();
//			$table->text('description');
//			$table->unsignedInteger('organization_id')->index();
//			$table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
//			$table->unsignedInteger('project_id')->index();
//			$table->foreign('project_id')->references('id')->on('projects');
//			$table->string('logo')->nullable();
//			$table->timestamps();
//		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
//		Schema::drop('tasks');
	}

}
