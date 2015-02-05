<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskModule extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
//		Schema::create('task_statuses', function(Blueprint $table){
//			$table->increments('id');
//			$table->string('name');
//			$table->timestamps();
//		});
//
//		Schema::create('tasks', function(Blueprint $table)
//		{
//			$table->increments('id');
//			$table->string('name')->unique();
//			$table->string('slug')->unique();
//			$table->text('description');
//			$table->unsignedInteger('dependent_task_id')->index();
//			$table->foreign('dependent_task_id')->references('id')->on('tasks')->onDelete('cascade');
//			$table->unsignedInteger('project_id')->index();
//			$table->foreign('project_id')->references('id')->on('tasks')->onDelete('cascade');
//			$table->unsignedInteger('task_status_id')->index();
//			$table->foreign('task_status_id')->references('id')->on('task_statuses')->onDelete('cascade');
//			$table->unsignedInteger('complexity_point')->index();
//			$table->unsignedInteger('task_state_id')->index();
//			$table->timestamps();
//		});
//
//		Schema::create('sprints', function(Blueprint $table)
//		{
//			$table->increments('id');
//			$table->string('name');
//			$table->unsignedInteger('project_id')->index();
//			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
//			$table->timestamp('deadline');
//			$table->timestamps();
//		});
//
//		Schema::create('task_tags', function(Blueprint $table){
//			$table->increments('id');
//			$table->string('name')->unique();
//			$table->string('color');
//			$table->timestamps();
//		});
//
//		Schema::create('task_task_tag', function(Blueprint $table){
//			$table->increments('id');
//			$table->integer('task_id')->unsigned()->index();
//			$table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
//			$table->integer('tag_id')->unsigned()->index();
//			$table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
//			$table->timestamps();
//		});
//
//		Schema::create('task_comments', function(Blueprint $table){
//			$table->increments('id');
//			$table->text('comment');
//			$table->timestamps();
//		});
//
//		Schema::create('task_task_comments', function(Blueprint $table){
//			$table->increments('id');
//			$table->unsignedInteger('task_id')->index();
//			$table->foreign('task_id')->on('tasks')->onDelete('cascade');
//			$table->unsignedInteger('task_comment_id')->index();
//			$table->foreign('issue_id')->on('tasks_comments')->onDelete('cascade');
//			$table->timestamps();
//		});
//

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
//		Schema::drop('task_statuses');
//		Schema::drop('tasks');
//		Schema::drop('sprints');
//		Schema::drop('task_tags');
//		Schema::drop('task_task_tag');
//		Schema::drop('task_comments');
	}

}
