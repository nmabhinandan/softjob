<?php

/**
 * Login isn't required
 */
Route::group([ 'domain' => 'internal.softjob.app' ], function() {

	Route::post('auth/login','AuthController@login');
	Route::get('auth/logout','AuthController@logout');
	Route::post('auth/resend','AuthController@resend');

	Route::get('/test', function() {

	});

});

/**
 * Login is required
 */
Route::group(['domain' => 'internal.softjob.app', 'middleware' => 'jwt'], function() {

	Route::get('/ui/sidebar/items', 'SidebarItemsController@get');

	Route::get('users/{id}/avatar', 'UserController@avatar');
	Route::get('users/{id}/projects', 'ProjectsController@getProjectsOfUser');

	Route::get('/projects', 'ProjectsController@getAllProjects');
	Route::post('/projects', 'ProjectsController@createProject');
	Route::get('/projects/{projectId}', 'ProjectsController@getProject');
	Route::get('/projects/{projectId}/tags', 'ProjectsController@getProjectTags');

	Route::get('/tags/projects/all', function() {
		return [
			'asdf',
			'asdfghjh',
			'zxcv',
			'zxccvbb',
			'qwert',
			'qweterert'
		];
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

