<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectModule extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('projects', function ( Blueprint $table ) {

			$table->increments('id');
			$table->string('name')->index();
			$table->string('slug')->unique();
			$table->text('description');
			$table->unsignedInteger('organization_id')->index();
			$table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
			$table->string('owner_type');
			$table->unsignedInteger('owner_id')->index();
			$table->unsignedInteger('project_manager_id')->index();
			$table->foreign('project_manager_id')->references('id')->on('users');
			$table->string('logo')->nullable();
			$table->timestamp('deadline');
			$table->timestamps();
		});

		Schema::create('project_user', function ( Blueprint $table ) {

			$table->increments('id');
			$table->integer('user_id')->unsigned()->index();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('project_id')->unsigned()->index();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
			$table->timestamps();
		});

		Schema::create('project_tags', function ( Blueprint $table ) {

			$table->increments('id');
			$table->string('name')->unique();
			$table->integer('color_id')->unsigned();
			$table->foreign('color_id')->references('id')->on('tag_colors')->onDelete('cascade');
			$table->timestamps();
		});

		Schema::create('project_project_tag', function ( Blueprint $table ) {

			$table->increments('id');
			$table->integer('project_id')->unsigned()->index();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
			$table->integer('project_tag_id')->unsigned()->index();
			$table->foreign('project_tag_id')->references('id')->on('project_tags');
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

//		Schema::drop('projects');
//		Schema::drop('project_user');

	}

}
