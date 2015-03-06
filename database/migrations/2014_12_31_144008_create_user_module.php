<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserModule extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->text('description');
			$table->timestamps();
		});

		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('organization_id')->unsigned()->index();
			$table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
			$table->string('email')->unique();
			$table->string('username')->unique();
			$table->string('password', 60);
			$table->string('first_name');
			$table->string('last_name');
			$table->string('avatar');
			$table->unsignedInteger('role_id');
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
			$table->timestamps();
		});

		Schema::create('groups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->text('description');
			$table->timestamps();
		});

		Schema::create('group_user', function(Blueprint $table){
			$table->increments('id');
			$table->integer('group_id')->unsigned()->index();
			$table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
			$table->integer('user_id')->unsigned()->index();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->timestamps();
		});

		Schema::create('permissions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('permission')->unique();
			$table->timestamps();
		});

		Schema::create('permission_role', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('permission_id')->unique();
			$table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
			$table->unsignedInteger('role_id')->unique();
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
			$table->timestamps();
		});

		Schema::create('permission_user', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('permission_id')->unique();
			$table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
			$table->unsignedInteger('user_id')->unique();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->timestamps();
		});

		Schema::create('user_todos', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->unsignedInteger('user_id')->index();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->tinyInteger('done', false, true)->default(0)->index();
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
		Schema::drop('users');
		Schema::drop('group_user');
		Schema::drop('roles');
		Schema::drop('permissions');
		Schema::drop('role_permissions');
		Schema::drop('user_permissions');
		Schema::drop('user_todos');
	}

}
