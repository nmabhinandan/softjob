<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueModule extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('issue_stages', function ( Blueprint $table ) {
			$table->increments('id');
			$table->string('name');
			$table->unsignedInteger('order')->index();
			$table->timestamps();
		});

		Schema::create('issues', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('slug')->unique();
			$table->text('description');
			$table->unsignedInteger('product_id')->index();
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->unsignedInteger('issue_stage_id')->index()->nullable();
			$table->foreign('issue_stage_id')->references('id')->on('issue_stages')->onDelete('cascade');
			$table->tinyInteger('issue_status', false, true)->index();
			$table->unsignedInteger('solved_by')->index()->nullable();
			$table->foreign('solved_by')->references('id')->on('users');
//			$table->string('priority')->index();
//			$table->timestamp('deadline');
			$table->timestamps();
		});

//		Schema::create('task_issue', function(Blueprint $table)
//		{
//			$table->increments('id');
//			$table->integer('task_id')->unsigned()->index();
//			$table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
//			$table->integer('issue_id')->unsigned()->index();
//			$table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');
//			$table->timestamps();
//		});
//
//		Schema::create('issue_tags', function(Blueprint $table)
//		{
//			$table->increments('id');
//			$table->string('name')->unique();
//			$table->timestamps();
//		});
//
//		Schema::create('issue_issue_tags', function(Blueprint $table)
//		{
//			$table->increments('id');
//			$table->unsignedInteger('issue')->index();
//			$table->foreign('issue')->references('id')->on('issues');
//			$table->unsignedInteger('issue_tag_id')->index();
//			$table->foreign('issue_tag_id')->references('id')->on('issue_tags');
//		});
//
//		Schema::create('issue_comments', function(Blueprint $table)
//		{
//			$table->increments('id');
//			$table->text('comment');
//			$table->timestamps();
//		});
//
//		Schema::create('issue_issue_comments', function(Blueprint $table)
//		{
//			$table->increments('id');
//			$table->unsignedInteger('issue_id')->index();
//			$table->foreign('issue_id')->on('issues')->onDelete('cascade');
//			$table->unsignedInteger('issue_comment_id')->index();
//			$table->foreign('issue_id')->on('issues_comments')->onDelete('cascade');
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
		Schema::drop('issues');
//		Schema::drop('task_issue');
//		Schema::drop('issue_tags');
//		Schema::drop('issue_comments');
//		Schema::drop('issue_issue_comments');
	}

}
