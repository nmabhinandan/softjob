<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationModule extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organizations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('slug');
			$table->text('description');
			$table->string('email')->nullable();
			$table->string('logo');
			$table->timestamps();
		});

		Schema::create('settings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('value');
			$table->unsignedInteger('organization_id')->index();
			$table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
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
		Schema::drop('organizations');
		Schema::drop('settings');
	}

}
