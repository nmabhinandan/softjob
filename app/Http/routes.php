<?php

/**
 * Login isn't required
 */
Route::group([ 'domain' => 'internal.softjob.app' ], function() {

	Route::post('auth/login','AuthController@login');
	Route::get('auth/logout','AuthController@logout');
	Route::post('auth/resend','AuthController@resend');

	Route::get('/test', function() {
//		return \Softjob\Project::find(7)->sprints()->with('tasks')->get();
		$sprints = \Softjob\Project::find(7)->sprints();
		return $sprints->with('tasks','workflow.stages')->get();


	});

});

/**
 * Login is required
 */
Route::group(['domain' => 'internal.softjob.app', 'middleware' => 'jwt'], function() {

	Route::get('/ui/sidebar/items', 'SidebarItemsController@get');

	Route::get('users/{id}/avatar', 'UserController@avatar');
	Route::get('users/{id}/projects', 'ProjectsController@getProjectsOfUser');
	Route::get('users/{id}/projects/status', 'ProjectsController@getProjectsStatusOfUser');

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

	Route::get('/projects/{projectId}/sprints/status', 'SprintsController@getSprintsStatusOfProject');
	Route::get('/sprints/{sprint_id}', 'SprintsController@getSprint');


	Route::get('/tags/projects/all', function() {

	});
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

