<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaskModule extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sprints', function ( Blueprint $table ) {
			$table->increments('id');
			$table->string('name');
			$table->unsignedInteger('project_id')->index();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
			$table->timestamp('deadline');
			$table->timestamps();
		});

		Schema::create('project_sprint', function ( Blueprint $table ) {
			$table->increments('id');
			$table->unsignedInteger('project_id')->index();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
			$table->unsignedInteger('sprint_id')->index();
			$table->foreign('sprint_id')->references('id')->on('sprints')->onDelete('cascade');
			$table->timestamps();
		});

		Schema::create('workflows', function ( Blueprint $table ) {
			$table->increments('id');
			$table->string('name');
			$table->unsignedInteger('sprint_id')->index();
			$table->foreign('sprint_id')->references('id')->on('sprints')->onDelete('cascade');
			$table->timestamps();
		});

		Schema::create('workflow_stages', function ( Blueprint $table ) {
			$table->increments('id');
			$table->string('name');
			$table->unsignedInteger('workflow_id')->index();
			$table->foreign('workflow_id')->references('id')->on('workflows')->onDelete('cascade');
			$table->unsignedInteger('order')->index();
			$table->timestamps();
		});

		Schema::create('tasks', function ( Blueprint $table ) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('slug')->unique();
			$table->text('description')->nullable();
			$table->unsignedInteger('dependent_task_id')->index()->nullable();
			$table->foreign('dependent_task_id')->references('id')->on('tasks')->onDelete('cascade');
			$table->unsignedInteger('project_id')->index();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
			$table->unsignedInteger('sprint_id')->index()->nullable();
			$table->foreign('sprint_id')->references('id')->on('sprints')->onDelete('cascade');
			$table->unsignedInteger('workflow_stage_id')->index()->nullable();
			$table->foreign('workflow_stage_id')->references('id')->on('workflow_stages')->onDelete('cascade');
			$table->unsignedInteger('complexity_point')->index();
			$table->unsignedInteger('completed_by')->index()->nullable();
			$table->foreign('completed_by')->references('id')->on('users');
			$table->tinyInteger('task_status', false, true)->index();
			$table->timestamp('completed_at');
			$table->timestamps();
		});


//		Schema::create('sprint_task', function ( Blueprint $table ) {
//			$table->increments('id');
//			$table->unsignedInteger('sprint_id')->index();
//			$table->foreign('sprint_id')->references('id')->on('sprints')->onDelete('cascade');
//			$table->unsignedInteger('task_id')->index();
//			$table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
//			$table->timestamps();
//		});

		Schema::create('task_tags', function ( Blueprint $table ) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('color');
			$table->timestamps();
		});

		Schema::create('task_task_tag', function ( Blueprint $table ) {
			$table->increments('id');
			$table->integer('task_id')->unsigned()->index();
			$table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
			$table->integer('tag_id')->unsigned()->index();
			$table->foreign('tag_id')->references('id')->on('task_tags')->onDelete('cascade');
			$table->timestamps();
		});

		Schema::create('task_comments', function ( Blueprint $table ) {
			$table->increments('id');
			$table->text('comment');
			$table->timestamps();
		});

		Schema::create('task_task_comments', function ( Blueprint $table ) {
			$table->increments('id');
			$table->unsignedInteger('task_id')->index();
			$table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
			$table->unsignedInteger('task_comment_id')->index();
			$table->foreign('task_comment_id')->references('id')->on('task_comments')->onDelete('cascade');
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
		Schema::drop('task_statuses');
		Schema::drop('tasks');
		Schema::drop('sprints');
		Schema::drop('task_tags');
		Schema::drop('task_task_tag');
		Schema::drop('task_comments');
	}

}
