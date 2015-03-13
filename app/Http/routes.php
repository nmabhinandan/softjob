<?php

/**
 * Login isn't required
 */
Route::group([ 'domain' => 'internal.' . preg_replace('#^https?://#', '', Config::get('app.url')) ], function() {

	Route::post('auth/login','AuthController@login');
	Route::get('auth/logout','AuthController@logout');
	Route::post('auth/resend','AuthController@resend');

	// Route::get('/test', function() {
	// 	return 'test';
	// });

	Route::get('/resetapp', function() {
		\Illuminate\Database\Eloquent\Model::unguard();
		DB::table('organizations')->delete();
		Softjob\Organization::create([
			'id'    => 1,
			'name'  => 'Organization One',
			'slug'  => 'org1',
			'email' => null,
			'logo'  => 'default'
		]);
		DB::table('users')->delete();
		Softjob\User::create([
			'id' => 21,
			'organization_id' => 1,
			'email' => 'admin@email.com',
			'username' => 'admin',
			'password' => Hash::make('secret'),
			'first_name' => 'TestFirstName',
			'last_name' => 'TestLastName',
			'avatar' => 'default.jpg',
			'role_id' => 1
		]);
		Db::table('roles')->delete();
		Role::create([
			'id' => 1,
			'name' => 'AdminRole',
			'description' => 'Admin Role description'
		]);
		$p = \Softjob\Permission::where('permission', '=' ,'role.edit')->get()->toArray();
		$p = array_pop($p);
		\Softjob\Role::find(1)->permissions()->attach($p['id']);
	});

});

/**
 * Login is required
 */
Route::group(['domain' => 'internal.' . preg_replace('#^https?://#', '', Config::get('app.url')), 'middleware' => 'jwt'], function() {

	Route::get('/ui/sidebar/items', 'SidebarItemsController@get');

	Route::post('users', 'UserController@createUser');
	Route::patch('users/edit', 'UserController@editUser');
	Route::get('users/all', 'UserController@getAllUsers');
	Route::get('users/all/raw', 'UserController@getRawUsers');
	Route::get('users/{userId}', 'UserController@getUser');

	Route::get('todos/of/{userId}/', 'UserController@getTodos');
	Route::get('todos/clear', 'UserController@clearTodos');
	Route::post('todos', 'UserController@createTodo');
	Route::patch('todos', 'UserController@completeTodo');

	Route::get('permissions/of/user/{userId}', 'PermissionsController@getUserPermissions');
	Route::get('permissions/of/role/{roleId}', 'PermissionsController@getRolePermissions');
	Route::post('permissions', 'PermissionsController@editPermission');
	Route::get('permissions/{permission}', 'PermissionsController@checkPermission');

	Route::get('users/{id}/projects', 'ProjectsController@getProjectsOfUser');
	Route::get('users/{id}/projects/status', 'ProjectsController@getProjectsStatusOfUser');

	Route::post('/project/addusers', 'ProjectsController@addUsersToProject');
	Route::get('/projects', 'ProjectsController@getAllProjects');
	Route::post('/projects', 'ProjectsController@createProject');
	Route::get('/projects/{slug}', 'ProjectsController@getProject');
	Route::get('/projects/id/{projectId}', 'ProjectsController@getProjectById');
	Route::get('/projects/{projectId}/tasks', 'ProjectsController@getProjectTasks');
	Route::get('/projects/{projectId}/velocity', 'ProjectsController@getProjectVelocity');
	Route::get('/projects/{projectId}/tasks/available', 'ProjectsController@getAvailableProjectTasks');
	Route::get('/projects/{projectId}/sprints', 'ProjectsController@getProjectSprints');
	Route::get('/projects/{projectId}/tags', 'ProjectsController@getProjectTags');

	Route::post('/tasks', 'TaskController@createTask');
	Route::post('/tasks/tranfer', 'TaskController@tranferTask');

	Route::get('/projects/{projectId}/sprints/status', 'SprintsController@getSprintsStatusOfProject');
	Route::get('/sprints/{sprint_id}', 'SprintsController@getSprint');
	Route::post('/sprints', 'SprintsController@createSprint');
	Route::get('/sprints/{sprintId}/burndown', 'SprintsController@getSprintBurndown');

	Route::get('workflows/all', 'SprintsController@getAllWorkflows');
	Route::get('workflows/{workflowId}/stages', 'SprintsController@getWorkflowStages');


	Route::get('roles/all', 'RolesController@getAllRoles');
	Route::get('roles/{roleId}', 'RolesController@getRole');
	Route::post('roles', 'RolesController@setRole');
	Route::patch('roles/edit', 'RolesController@updateRole');
	Route::delete('roles/{roleId}', 'RolesController@deleteRole');

	Route::get('groups/all', 'GroupsController@getAllGroups');
	Route::get('groups/{groupId}', 'GroupsController@getGroup');
	Route::post('groups', 'GroupsController@setGroup');
	Route::patch('groups/edit', 'GroupsController@updateGroup');
	Route::get('groups/{groupId}/addableusers', 'GroupsController@usersNotInGroup');
	Route::post('groups/users', 'GroupsController@addUsers');
	Route::delete('groups/{groupId}', 'GroupsController@deleteGroup');

	Route::get('settings/{setting}', 'SettingsController@getSetting');
	Route::post('settings', 'SettingsController@setSetting');
});

/**
 * Home page
 */
Route::get('/', function() {
	return View::make('home');
});

Route::options('{all}', function() {

	$response = Response::make(null, 200);
	$response->headers->set('Access-Control-Allow-Origin', Config::get('app.url'));
	$response->headers->set('Access-Control-Allow-Methods', 'PUT, POST, GET, DELETE, PATCH, OPTIONS');
	$response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Authorization');

	return $response;
})->where(['all' => '.*']);

