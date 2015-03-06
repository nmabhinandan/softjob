softjob.config(['$stateProvider', '$urlRouterProvider', '$httpProvider', '$mdThemingProvider', 'cfpLoadingBarProvider', function ($stateProvider, $urlRouterProvider, $httpProvider, $mdThemingProvider, cfpLoadingBarProvider) {
		'use strict';
		$httpProvider.interceptors.push('AuthInterceptor');
		$stateProvider.state('dashboard', {
			url: '/',
			templateUrl: 'templates/dashboard.html',
			controller: 'DashboardController',
			auth: true
		}).state('404', {
			url: '/404',
			templateUrl: 'templates/404.html',
			auth: false
		}).state('login', {
			url: '/login',
			templateUrl: 'templates/login.html',
			controller: 'LoginController',
			auth: false
		}).state('dashboard.projects', {			
			url: 'projects',
			controller: 'ProjectListController',
			templateUrl: '/templates/projects.html',
		}).state('dashboard.projectPage', {
			url: 'projects/{projectSlug}',
			controller: 'ProjectsController',			
			templateUrl: '/templates/project_page.html'
		}).state('dashboard.sprintPage', {
			url: 'projects/{projectId}/sprints',
			controller: 'SprintsController',			
			templateUrl: '/templates/sprint_page.html'
		}).state('dashboard.sprint', {
			url: 'sprints/{sprintId}',
			controller: 'SprintController',			
			templateUrl: '/templates/sprint.html'
		}).state('dashboard.admin', {
			url: 'admin',
			controller: 'AdminController',			
			templateUrl: '/templates/admin.html'
		}).state('dashboard.userPage', {
			url: 'users/{userId}',
			controller: 'UserController',
			templateUrl: '/templates/admin_user_page.html'
		}).state('dashboard.roles', {
			url: 'admin/roles',		
			controller: 'AdminRolesController',
			templateUrl: '/templates/admin_roles.html'
		}).state('dashboard.rolePage', {
			url: 'roles/{roleId}',
			controller: 'RoleController',
			templateUrl: '/templates/admin_role_page.html'
		}).state('dashboard.groups', {
			url: 'admin/groups',		
			controller: 'AdminGroupsController',
			templateUrl: '/templates/admin_groups.html'
		}).state('dashboard.groupPage', {
			url: 'groups/{groupId}',
			controller: 'GroupController',
			templateUrl: '/templates/admin_group_page.html'
		}).state('dashboard.workspace', {
			url: 'workspace',
			params: {
				sprintId: {value: null}
			},
			controller: 'WorkspaceController',
			templateUrl: '/templates/workspace.html'
		}).state('dashboard.issues', {
			url: 'issues/{productId}',
			params: {
				productId: {value: null}
			},
			controller: 'IssuesController',
			templateUrl: '/templates/issues.html'
		});

		

		$urlRouterProvider.otherwise('404');

		$mdThemingProvider.theme('indigo')		
			.primaryPalette('indigo');

		
		cfpLoadingBarProvider.loadingBarColor = '#BFFF00';
		cfpLoadingBarProvider.includeSpinner = false;
		cfpLoadingBarProvider.parentSelector = 'body';
	}])
	.run(['$rootScope', '$state', '$timeout', '$mdToast', 'User', function ($rootScope, $state, $timeout, $mdToast, User) {
		$rootScope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams){
			if(toState.auth != false) {
				if(! User.isLoggedIn()) {
					$timeout(function () {
						$state.go('login');
						$mdToast.show($mdToast.simple().content('You are not authorized to access that resource.'));
					});
				}
			}
			if(toState.auth === false) {
				if(User.isLoggedIn()) {
					$timeout(function () {
						$state.go('dashboard');
						//$mdToast.show($mdToast.simple().content('You are already logged in.'));
					});
				}
			}
		});

		if(User.isLoggedIn()) {
			$rootScope.loggedInUser = User.getUser();
		}
	}])
	.constant('softjobConfig', {
		APP_BACKEND: window.location.protocol + '//internal.' + window.location.host
	});