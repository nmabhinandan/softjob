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
			templateUrl: '/templates/projects.html',			
		});

		$urlRouterProvider.otherwise('/404');

		$mdThemingProvider.theme('teal')
			.primaryPalette('teal');

		
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