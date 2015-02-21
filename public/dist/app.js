/** jshint ignore: start */
var softjob = angular.module('softjob', [
	'ngMaterial',
	'angular-loading-bar',
	'ngAnimate',
	'ui.router',
	'chart.js',
	'ngDraggable',
	'sjServices',
	'sjControllers',
	'sjDirectives'
]);

var sjServices = angular.module('sjServices', []);
var sjDirectives = angular.module('sjDirectives', []);
var sjControllers = angular.module('sjControllers', []);
sjServices.factory('Auth', ['$http', '$window', '$q', '$rootScope', 'softjobConfig', 'User', '$mdToast', '$state',
	function($http, $window, $q, $rootScope, softjobConfig, User, $mdToast, $state) {
	'use strict';

	var service = {};
		
	service.login = function (formData) {
		$http({
			method: 'post',
			url: softjobConfig.APP_BACKEND + '/auth/login',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {
			User.setToken(data.data.token);
			User.setUser(data.data.user);
			$rootScope.organization = data.data.organization;
			$state.go('dashboard');
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	};

	service.logout = function () {
		User.removeUser();
		$window.localStrage.removeItem('softjob.token');
		$state.go('login');
	};

	service.resend = function (emailId) {
		$http({
			method: 'post',
			url: softjobConfig.APP_BACKEND + '/auth/resend',
			data: emailId,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content('Please check your inbox to confirm your email adress'));
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	};
	return service;
}]);
sjServices.factory('AuthInterceptor', ['$window', '$q', function ($window, $q) {
	'use strict';
	var service = {};

	service.request = function (config) {
		var deferred = $q.defer();
		if($window.localStorage.getItem('softjob.token') !== null) {
			config.headers.Authorization = 'Bearer ' + $window.localStorage.getItem('softjob.token');
		}
		return config;
	};

	service.response = function (response) {
		return response;
	};
	return service;
}]);
sjServices.factory('Project', ['User', '$http', '$q', '$state', '$mdToast', 'softjobConfig', function(User, $http, $q, $state, $mdToast, softjobConfig){
	var instance = {};
	instance.getProjects = function (userId) {
		var deferred = $q.defer();
		$http({
			method: 'GET',
			url: softjobConfig.APP_BACKEND + '/users/' + userId + '/projects'		
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject();			
		});

		return deferred.promise;
	};

	instance.getProjectById = function(projectId) {
		var deferred = $q.defer();
		$http({
			method: 'GET',
			url: softjobConfig.APP_BACKEND + '/projects/id/' + projectId
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject();
		});
		
		return deferred.promise;
	};

	instance.getProjectBySlug = function(slug) {
		var deferred = $q.defer();
		$http({
			method: 'GET',
			url: softjobConfig.APP_BACKEND + '/projects/' + slug
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject();
		});
		
		return deferred.promise;
	};

	instance.getProjectsStatus = function (userId) {
		var deferred = $q.defer();
		$http({
			method: 'GET',
			url: softjobConfig.APP_BACKEND + '/users/' + userId + '/projects/status'		
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject();			
		});
		
		return deferred.promise;
	};

	instance.getProjectVelocity = function (projectId) {
		var deferred = $q.defer();
		$http({
			method: 'GET',
			url: softjobConfig.APP_BACKEND + '/projects/' + projectId + '/velocity'		
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject();			
		});
		
		return deferred.promise;
	};

	instance.getProjectSprintStatus = function (projectId) {
		var deferred = $q.defer();
		$http({
			method: 'GET',
			url: softjobConfig.APP_BACKEND + '/projects/' + projectId + '/sprints/status'		
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject();			
		});
		
		return deferred.promise;
	};

	instance.createProject = function (formData) {
		$http({
			method: 'post',
			url: softjobConfig.APP_BACKEND + '/projects',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			$state.go('dashboard.projects');
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	};
	return instance;
}]);
sjServices.factory('Sprint', ['$http', '$q', '$mdToast', 'softjobConfig', 'User', function ($http, $q, $mdToast, softjobConfig, User) {
	'use strict';
	var service = {};
	
	service.getSprintsOfProject = function (projectId) {
		var deferred = $q.defer();
		$http({
			method: 'GET',
			url: softjobConfig.APP_BACKEND + '/projects/' + projectId + '/sprints'
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject();			
		});

		return deferred.promise;
	};

	
	return service;
}]);
sjServices.service('Tag', ['$http', '$q', 'softjobConfig', function($http, $q, softjobConfig){
	
	var serviceInstance = {};

	serviceInstance.getAllProjectTags = function() {
		var deferred = $q.defer();

		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/tags/projects/all'
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.resolve(data);
		});		

		return deferred.promise;
	};

	return serviceInstance;
}]);
sjServices.factory('Task', ['$http', '$q', 'softjobConfig', 'User', function ($http, $q, softjobConfig, User) {
	'use strict';
	var service = {};
	
	service.getTasksOfProject = function (projectId) {
		var deferred = $q.defer();
		$http({
			method: 'GET',
			url: softjobConfig.APP_BACKEND + '/projects/' + projectId + '/tasks'
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject();			
		});

		return deferred.promise;
	};

	service.createTask = function(formData) {
		$http({
			method: 'post',
			url: softjobConfig.APP_BACKEND + '/tasks',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content('Task has been created'));
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	}
	return service;
}]);
sjServices.factory('UI', ['$http', 'softjobConfig', '$q', function($http, softjobConfig, $q){
	'use strict';
	var serviceInstance = {};
	serviceInstance.getSidebarItems = function () {
		var deferred = $q.defer();

		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/ui/sidebar/items'
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise;
	};
	return serviceInstance;
}]);
sjServices.factory('User', ['$q', '$window', 'softjobConfig', '$rootScope', '$http',
	function ($q, $window, softjobConfig, $rootScope, $http) {
	'use strict';
	var service = {};
	var userToken;
	service.setUser = function (user) {
		$rootScope.loggedInUser = user;
		$window.localStorage.setItem('softjob.user',JSON.stringify(user));
	};

	service.setToken = function (token) {
		$window.localStorage.setItem('softjob.token',token);
		userToken = token;
	};

	service.isLoggedIn = function () {
		if(userToken || $window.localStorage.getItem('softjob.token')) {
			return true;
		} else {
			return false;
		}
	};

	service.getToken = function () {
		if(userToken) {
			return userToken;
		}

		return $window.localStorage.getItem('softjob.token');
	};

	service.getUser = function () {
		return JSON.parse($window.localStorage.getItem('softjob.user'));
	};

	service.removeUser = function () {
		$rootScope.loggedInUser = null;
		userToken = null;
		$window.localStorage.removeItem('softjob.user');
	};

	service.getUserById = function(id) {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/users/get',
			data: id,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise();
	};

	service.getUsersByGroup = function (group) {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/users/group',
			data: group,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise();
	};
	service.getUsersByProject = function(project) {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/users/project',
			data: project,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise();
	};			
	service.getUserAvatar = function () {
		var user = JSON.parse($window.localStorage.getItem('softjob.user'));
		return '/img/avatars/' + user.avatar;
	};
	
	service.getOptionItems = function (user) {
		if(user == User.getUser()) {
			return [
				{
					name: 'Profile Settings',
					icon: 'ion-gear-b'
				}
			];
		}
	};
	return service;
}]);

sjControllers.controller('DashboardController', ['$scope', '$rootScope', '$state', 'Task', 'Auth', 'User', 'UI', function ($scope, $rootScope, $state, Task, Auth, User, UI) {
	'use strict';

	$rootScope.pageTitle = 'Dashboard';
	
	UI.getSidebarItems().then(function(data) {
		$scope.sidebarItems = data;
	});
	
	$scope.navigateTo = function(state) {
		$state.go(state);
	};
}]);
sjControllers.controller('HomeController', ['$scope', function ($scope) {
	'use strict';

}]);
sjControllers.controller('LoginController', ['$scope', 'Auth', function ($scope, Auth) {
	'use strict';
	$scope.submit = function(user) {
		Auth.login(user);
	};
}]);
sjControllers.controller('ProjectListController', ['$scope', '$rootScope', '$mdDialog', '$mdToast', 'Project', 
	function($scope, $rootScope, $mdDialog, $mdToast, Project){
	$rootScope.pageTitle = 'Projects';
	$scope.chart = {
		labels: [],
		data: [],
		options: {
			responsive: true,
			barShowStroke : false,
			scaleShowVerticalLines: false,
			barValueSpacing: 20,
		}
	}


	Project.getProjectsStatus($rootScope.loggedInUser.id).then(function(data) {				
		var statuses = [];
		angular.forEach(data,function(value) {			
			$scope.chart.labels.push(value.name.substring(0, 12).toUpperCase()+'...');
			statuses.push(value.status);
		});		
		$scope.chart.data.push(statuses);		
	});	

	$scope.createProject = function(ev) {
		$mdDialog.show({			
			controller: ['$scope','$mdDialog','$rootScope', function($scope,$mdDialog,$rootScope) {				
				$scope.cancel = function() {					
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {
					data.owner_type = 'user';
					data.owner_id = $rootScope.loggedInUser.id;
					data.organization_id = $rootScope.loggedInUser.organization_id;
					data.project_manager_id = $rootScope.loggedInUser.id;
					console.log(data);
					$mdDialog.hide(data);
				}

				$scope.makeSlug = function(str) {
					$scope.project.slug = str.toLowerCase()
											.replace(/[^\w ]+/g,'')
											.replace(/ +/g,'-');
				}; 
			}],
      		templateUrl: 'templates/forms/create_project.html',
      		targetEvent: ev,
		}).then(function(data) {
			Project.createProject(data);
			$mdToast.show($mdToast.simple().content("New project is created"));		
		});
	};
}]);
sjControllers.controller('ProjectsController', ['$scope', '$rootScope', '$stateParams', '$mdDialog', 'Project', function($scope, $rootScope, $stateParams, $mdDialog, Project) {

	$scope.project = {};

	$scope.chart = {
		labels: [],
		series: ['Ideal velocity', 'Current velocity'],
		data: [],
		options: {
			responsive: true,											
		}		
	}



	Project.getProjectBySlug($stateParams.projectSlug).then(function(data) {
		$scope.project = data;
		$scope.deadline = moment(data.deadline).calendar();
		$rootScope.pageTitle = data.name;
		
		
		for (var date = moment(data.created_at); date.isBefore(moment(data.deadline).add(1,'day')); date.add(1, 'day')) {
			$scope.chart.labels.push(date.fromNow());
		};

		Project.getProjectVelocity(data.id).then(function(data) {				
			var velocity = [];
			var idealVelocity = [];
			
			angular.forEach(data.ideal_velocity,function(value) {				
				idealVelocity.push(value);
			});
			$scope.chart.data.push(idealVelocity);
			
			angular.forEach(data.current_velocity,function(value) {
				velocity.push(value);
			});			
			$scope.chart.data.push(velocity);						
		});

		Project.getProjectSprintStatus(data.id).then(function(data) {
			$scope.sprints = data;
		});
	});	
}]);
sjControllers.controller('SprintsController', ['$scope', '$stateParams', '$mdDialog', 'Project', 'Task', 'Sprint',
 function($scope, $stateParams, $mdDialog, Project, Task, Sprint){	 	

 	var backlogChecks = 0;
 	$scope.selectedBacklogTasks = [];
	
	Project.getProjectById($stateParams.projectId).then(function(data) {
		$scope.project = data;
		
		$scope.pageTitle = data.name;
		getTasksOfProject();
		getSprintsOfProject()
	});

	function getTasksOfProject() {
		Task.getTasksOfProject($scope.project.id).then(function(data) {
			var freeTasks = [];
			var allTasks = [];
			angular.forEach(data,function(value) {
				allTasks.push(value);
				if(value.sprint_id === null) {
					freeTasks.push(value);
				}
				$scope.project.tasks = allTasks;
				$scope.project.freeTasks = freeTasks;
			});			
		});
	}

	function getSprintsOfProject() {
		Sprint.getSprintsOfProject($scope.project.id).then(function(data) {
			$scope.sprints = data;						
			angular.forEach($scope.sprints, function(sprint) {
				var totalTasks = 0;
				angular.forEach(sprint.tasks,function(task) {
					totalTasks += 1;
				});				
			});
			console.log($scope.sprints);
		});		
	}

	$scope.backlogChanged = function(taskId, state) {		
		if(state) {
			backlogChecks += 1;
			$scope.selectedBacklogTasks.push(taskId);
		} else {
			backlogChecks -= 1;
			var indx = $scope.selectedBacklogTasks.indexOf(taskId);
			if(indx > -1) {
				$scope.selectedBacklogTasks.splice(indx,1);
			}
		}		
	};

	$scope.isBacklogChecked = function() {
		return (backlogChecks > 0) ? true : false;
	};

	$scope.createTask = function(ev) {
		$mdDialog.show({
			locals: {
				project: $scope.project
			},
			controller: ['$scope','$mdDialog', 'project', function($scope,$mdDialog,project) {
				$scope.tasks = project.tasks;				
				$scope.cancel = function() {					
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {
					data.Project_id = project.id;
					$mdDialog.hide(data);
				}

				$scope.makeSlug = function(str) {
					$scope.task.slug = str.toLowerCase()
											.replace(/[^\w ]+/g,'')
											.replace(/ +/g,'-');
				}; 
			}],
      		templateUrl: 'templates/forms/create_task.html',
      		targetEvent: ev
		}).then(function(data) {
			Task.createTask(data);
			getTasksOfProject();
		});
	};
}]);
sjDirectives.directive('sjProjectsList', [ function(){	
	return {		
		
		scope: {
			user: '='
		}, // {} = isolate, true = child, false/undefined = no change

		controller: ['$scope', 'Project', 'User', function($scope, Project, User) {			
			Project.getProjects($scope.user.id).then(function(data) {				
				$scope.projects = data;	
			});			
		}],		
		restrict: 'E', // E = Element, A = Attribute, C = Class, M = Comment		
		templateUrl: 'directives/projects_list.html',
		replace: true,
		// compile: function(tElement, tAttrs, function transclude(function(scope, cloneLinkingFn){ return function linking(scope, elm, attrs){}})),
		// link: function($scope, iElm, iAttrs, controller) {
			
		// }
	};
}]);
sjDirectives.directive('sjTag', [function(){
	// Runs during compile
	return {
		scope: {
			input: '=',			
			tags: '='
			// placeholder: '@',
			// project: '=',
			// task: '=',
		}, // {} = isolate, true = child, false/undefined = no change
		// require: 'ngModel',

		controller: ['$scope', 'Project', 'User', 'Tag', function($scope, Project, User, Tag) {
		// 	var projectServerTags = [];
		// 	var taskServerTags = [];	
		// 	$scope.finalTags = [];
		// 	if($scope.project !== undefined) {
		// 		Tag.getAllProjectTags().then(function(data) {
		// 			projectServerTags = data;					
		// 		});
		// 	}
			
		// 	$scope.tagSubmitted = function(val) {
		// 		// console.log(val);
		// 		$scope.finalTags.push(val);
		// 	};

		// 	$scope.tagChanged = function(val) {
		// 		var tagString = val.trim();
		// 		var newTag = '';
		// 		if(tagString.slice(-1) == ",") {
		// 			for(var i=tagString.length-1;i>=0;i--) {						
		// 				console.log(tagString[i]);
		// 				newTag += tagString[i];
		// 				if(tagString[i] == ",") {
		// 					break;
		// 				}
		// 			}
		// 			$scope.tagSubmitted(newTag);
		// 		}
		// 	};			
		}],		
		restrict: 'E', // E = Element, A = Attribute, C = Class, M = Comment		
		templateUrl: 'directives/tags.html',
		replace: true,
		// compile: function(tElement, tAttrs, function transclude(function(scope, cloneLinkingFn){ return function linking(scope, elm, attrs){}})),
		// link: function($scope, iElm, iAttrs, ngModel) {			
			// $scope.$watch('tags', function(val) {
			// 	ngModel.$setViewValue(val);				
			// });			
		// }
	};
}]);
sjDirectives.directive('sjUserAvatar', [function () {
	return {
		restrict: 'E',
		replace: true,
		scope: {
			user: '='
		},
		controller: ['$scope', '$mdBottomSheet', function ($scope, $mdBottomSheet) {

			$scope.showOptions = function () {
				$mdBottomSheet.show({
					templateUrl: 'directives/user_avatar.options.html',
					controller: ['$scope', 'User', function ($scope, User) {
						$scope.optionItems = [
							{
								name: 'Profile Settings',
								icon: 'ion-gear-b'
							},
							{
								name: 'Logout',
								icon: 'ion-gear-b'
							}
						];
					}]
				});
			};
		}],
		templateUrl: 'directives/user_avatar.html'
	};
}]);
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
		});

		$urlRouterProvider.otherwise('/404');

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