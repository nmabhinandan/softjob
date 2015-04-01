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
		}).state('logout', {
			url: '/logout',			
			controller: ['$scope', '$state', '$mdBottomSheet', 'User', function($scope, $state, $mdBottomSheet, User) {
				User.removeUser();
				$state.go('login');
				$mdBottomSheet.hide();
			}],
			auth: true
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
		}).state('dashboard.mail', {
			url: 'admin/mail',		
			controller: 'MailSettingController',
			templateUrl: '/templates/admin_mail.html'
		}).state('dashboard.workspace', {
			url: 'workspace',
			params: {
				sprintId: {value: null}
			},
			controller: 'WorkspaceController',
			templateUrl: '/templates/workspace.html'
		}).state('dashboard.issues', {
			url: 'issues/',
			params: {
				productId: {value: null}
			},
			controller: 'IssuesController',
			templateUrl: '/templates/issues.html'
		}).state('dashboard.custIssueView', {
			url: 'support/{productId}',
			params: {
				productId: {value: null}
			},
			controller: 'CustIssueViewController',
			templateUrl: '/templates/cust_issue_view.html'
		});

		

		$urlRouterProvider.otherwise('404');

		$mdThemingProvider.theme('indigo')		
			.primaryPalette('indigo')
			.accentPalette('purple');

		
		cfpLoadingBarProvider.loadingBarColor = '#BFFF00';
		cfpLoadingBarProvider.includeSpinner = false;
		cfpLoadingBarProvider.parentSelector = 'body';
	}])
	.run(['$rootScope', '$state', '$timeout', '$mdToast', 'User', 'Permission', function ($rootScope, $state, $timeout, $mdToast, User, Permission) {
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
						$mdToast.show($mdToast.simple().content('You are already logged in.'));
					});
				}
			}
		});

		if(User.isLoggedIn()) {
			$rootScope.loggedInUser = User.getUser();
		}

		$rootScope.checkPermission = function(perm) {						
			return Permission.checkPermission(perm);
		};
	}])
	.constant('softjobConfig', {
		APP_BACKEND: window.location.protocol + '//internal.' + window.location.host
	});