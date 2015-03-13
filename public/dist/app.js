/** jshint ignore: start */
var softjob = angular.module('softjob', [
	'ngMaterial',
	'angular-loading-bar',
	'ngAnimate',
	'ui.router',
	'ui.keypress',
	'chart.js',
	'ngDraggable',
	'sjServices',
	'sjControllers',
	'sjDirectives'
]);

var sjServices = angular.module('sjServices', []);
var sjDirectives = angular.module('sjDirectives', []);
var sjControllers = angular.module('sjControllers', []);
sjServices.factory('Auth', ['$http', '$window', '$q', '$rootScope', 'softjobConfig', 'User', 'Permission', '$mdToast', '$state',
	function($http, $window, $q, $rootScope, softjobConfig, User, Permission, $mdToast, $state) {
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
			Permission.cachePermissions(data.data.permissions);
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
sjServices.factory('Permission', ['$http', '$state', '$rootScope', '$mdToast', '$window', '$q', 'softjobConfig',
 function($http, $state, $rootScope, $mdToast, $window, $q, softjobConfig){
	var userPermissions = null;

	var instance = {};

	instance.getUserPermissions = function(userId) {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/permissions/of/user/' + userId
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise;
	};

	instance.getRolePermissions = function(roleId) {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/permissions/of/role/' + roleId
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise;
	};

	instance.setPermission = function(formData) {
		var deferred = $q.defer();
		$http({
			method: 'post',
			url: softjobConfig.APP_BACKEND + '/permissions',
			data: formData, 
			headers: { 'Content-Type': 'application/json' }
		}).success(function(data,status,headers,config) {
			$mdToast.show($mdToast.simple().content("Permissions chaned"));
			deferred.resolve(status);
		}).error(function(data,status,headers,config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject(status);
		});
		return deferred.promise;
	};

	instance.checkPermission = function(permission) {

		if(userPermissions == null) {			
			if($window.localStorage.getItem('softjob.permissions') === null) {				
				instance.getUserPermissions().then(function(data) {

					instance.cachePermissions(data);
					return instance.checkPermission(permission);
				});
			} else {				
				userPermissions = JSON.parse($window.localStorage.getItem('softjob.permissions'));
			}			
		}
		var flag = false;
		angular.forEach(userPermissions, function(perm) {			
			if(perm.permission === permission && perm.granted === true) {
				flag = true;
			}
		});
		return flag;
	}

	instance.cachePermissions = function(perms) {
		userPermissions = perms;
		$window.localStorage.setItem('softjob.permissions', JSON.stringify(perms));
	}

	return instance;
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
			$mdToast.show($mdToast.simple().content("New project is created"));			
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	};

	instance.addUserToProject = function (formData) {
		$http({
			method: 'post',
			url: softjobConfig.APP_BACKEND + '/project/addusers',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			$mdToast.show($mdToast.simple().content("Users added successfully"));			
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	};
	return instance;
}]);
sjServices.factory('Sprint', ['$http', '$q', '$mdToast', '$state', 'softjobConfig', 'User', function ($http, $q, $mdToast, $state, softjobConfig, User) {
	'use strict';
	var service = {};

	service.getSprintById = function (sprintId) {
		var deferred = $q.defer();
		$http({
			method: 'GET',
			url: softjobConfig.APP_BACKEND + '/sprints/' + sprintId
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject();
		});

		return deferred.promise;
	};

	service.getAllWorkflows = function() {
		var deferred = $q.defer();
		$http({
			method: 'GET',
			url: softjobConfig.APP_BACKEND + '/workflows/all'
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject();
		});

		return deferred.promise;
	}

	service.getSprintBurnDown = function(sprintId) {
		var deferred = $q.defer();
		$http({
			method: 'GET',
			url: softjobConfig.APP_BACKEND + '/sprints/' + sprintId + '/burndown'
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject();
		});

		return deferred.promise;
	}
	
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

	service.createSprint = function (formData) {
		$http({
			method: 'post',
			url: softjobConfig.APP_BACKEND + '/sprints',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			$mdToast.show($mdToast.simple().content("New sprint is created"));			
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	};

	service.getWorkflowStages = function(workflowId) {
		var deferred = $q.defer();
		$http({
			method: 'GET',
			url: softjobConfig.APP_BACKEND + '/workflows/' + workflowId + '/stages'
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject();
		});

		return deferred.promise;
	};

	service.tranferTask = function(formData) {
		var deferred = $q.defer();
		$http({
			method: 'post',
			url: softjobConfig.APP_BACKEND + '/tasks/tranfer',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			$mdToast.show($mdToast.simple().content("Task state changed"));	
			deferred.resolve();		
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject();
		});
		return deferred.promise;
	}
	
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
sjServices.factory('Task', ['$http', '$q', '$mdToast', 'softjobConfig', 'User', function ($http, $q, $mdToast, softjobConfig, User) {
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
sjServices.factory('User', ['$q', '$window', '$state', 'softjobConfig', '$rootScope', '$http', '$mdToast', 
	function ($q, $window, $state, softjobConfig, $rootScope, $http, $mdToast) {
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
		$window.localStorage.removeItem('softjob.token');
		$window.localStorage.removeItem('softjob.permissions');
	};

	service.getUserById = function(id) {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/users/' + id			
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise;
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
		return deferred.promise;
	};
	service.getUsersByProject = function(project) {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/users/project/' + projectId,			
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise;
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

	service.getTodods = function(userId) {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/todos/of/' + userId,
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise;
	};

	service.addTodo = function(formData) {		
		$http({
			method: 'post',
			url: softjobConfig.APP_BACKEND + '/todos',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			$mdToast.show($mdToast.simple().content("New todo is added"));
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	}

	service.completeTodo = function(formData) {
		var deferred = $q.defer();
		$http({
			method: 'patch',
			url: softjobConfig.APP_BACKEND + '/todos',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			deferred.resolve(status);
		}).error(function (data, status, headers, config) {
			deferred.reject(status);
		});
		return deferred.promise;
	}

	service.clearTodos = function() {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/todos/clear'
		}).success(function (data, status, headers, config) {			
			deferred.resolve(status);
		}).error(function (data, status, headers, config) {
			deferred.reject(status);
		});
		return deferred.promise;
	};

	service.getAllUsers = function() {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/users/all',						
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise;
	};			

	service.getRawUsers = function() {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/users/all/raw',						
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise;
	};			

	service.createUser = function (formData) {
		$http({
			method: 'post',
			url: softjobConfig.APP_BACKEND + '/users',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			$mdToast.show($mdToast.simple().content("User created successfully"));
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	};

	service.editUser = function (formData) {
		$http({
			method: 'patch',
			url: softjobConfig.APP_BACKEND + '/users/edit',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			$mdToast.show($mdToast.simple().content("Changes saved successfully"));
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	};

	service.getAllRoles = function() {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/roles/all',						
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise;
	};			
	service.getRole = function(roleId) {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/roles/' + roleId,
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise;	
	};


	service.editRole = function (formData) {
		$http({
			method: 'patch',
			url: softjobConfig.APP_BACKEND + '/roles/edit',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			$mdToast.show($mdToast.simple().content("Changes saved successfully"));
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	};

	service.creatRole = function (formData) {
		$http({
			method: 'post',
			url: softjobConfig.APP_BACKEND + '/roles',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			$mdToast.show($mdToast.simple().content("Role created successfully"));
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	};

	service.deleteRole = function(roleId) {
		$http({
			method: 'delete',
			url: softjobConfig.APP_BACKEND + '/roles/' + roleId,	
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			$mdToast.show($mdToast.simple().content("Role deleted successfully"));
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	}

	service.getAllGroups = function() {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/groups/all',						
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise;
	};			
	service.getGroup = function(groupId) {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/groups/' + groupId,
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise;	
	};


	service.editGroup = function (formData) {
		$http({
			method: 'patch',
			url: softjobConfig.APP_BACKEND + '/groups/edit',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			$mdToast.show($mdToast.simple().content("Changes saved successfully"));
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	};

	service.createGroup = function (formData) {
		$http({
			method: 'post',
			url: softjobConfig.APP_BACKEND + '/groups',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			$mdToast.show($mdToast.simple().content("Group created successfully"));
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	};

	service.deleteGroup = function(groupId) {
		$http({
			method: 'delete',
			url: softjobConfig.APP_BACKEND + '/groups/' + groupId,	
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			$mdToast.show($mdToast.simple().content("Group deleted successfully"));
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	}
	service.getUsersForGroup = function(groupId) {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/groups/' + groupId + '/addableusers',
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise;	
	}

	service.addUserToGroup = function(data) {
		$http({
			method: 'post',
			url: softjobConfig.APP_BACKEND + '/groups/users',
			data: data,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			$mdToast.show($mdToast.simple().content("Users are added successfully"));
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	};
	return service;
}]);
sjControllers.controller('AdminController', ['$scope', '$rootScope', '$mdDialog', 'User', function($scope, $rootScope, $mdDialog, User) {
	$rootScope.pageTitle = "Admin";
	function loadUsers() {
		User.getAllUsers().then(function(data) {
			$scope.usersdata = data;
		});
	}
	
	loadUsers();	

	$scope.createUser = function(ev) {		
		$mdDialog.show({			
			locals: {
				usersdata: $scope.usersdata
			},
			controller: ['$scope','$mdDialog', 'User', 'usersdata', function($scope,$mdDialog,User,usersdata) {
				$scope.usersdata = usersdata;
				
				
				$scope.cancel = function() {
					loadUsers();
					$mdDialog.cancel();
				}

				$scope.submit = function(data) {
					loadUsers();
					data.organization_id = 1;
					$mdDialog.hide(data);
				}
			}],
      		templateUrl: 'templates/forms/create_user.html',
      		targetEvent: ev
		}).then(function(data) {			
			User.createUser(data);
			loadUsers();
		});
	}
}]);
sjControllers.controller('AdminGroupsController', ['$scope', '$rootScope', '$mdDialog', 'User', 
	function($scope, $rootScope, $mdDialog, User){
	$rootScope.pageTitle = 'Admin';
	
	function loadGroups() {
		User.getAllGroups().then(function(data) {
			$scope.groups = data;
		});
	}
	loadGroups();

	$scope.createGroup = function(ev) {
		$mdDialog.show({			
			controller: ['$scope','$mdDialog', 'User', function($scope,$mdDialog,User) {								
				
				$scope.cancel = function() {
					loadGroups();
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {					
					loadGroups();
					$mdDialog.hide(data);
				}
			}],
      		templateUrl: 'templates/forms/create_group.html',
      		targetEvent: ev
		}).then(function(data) {
			User.createGroup(data);
			loadGroups();
		});
	}
}]);
sjControllers.controller('AdminRolesController', ['$scope', '$rootScope', '$mdDialog', 'User', function($scope, $rootScope, $mdDialog, User){
	$rootScope.pageTitle = 'Admin';
	
	function loadRoles() {
		User.getAllRoles().then(function(data) {
			$scope.roles = data;
		});
	}
	loadRoles();

	$scope.createRole = function(ev) {
		$mdDialog.show({			
			controller: ['$scope','$mdDialog', 'User', function($scope,$mdDialog,User) {								
				
				$scope.cancel = function() {
					loadRoles();
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {					
					loadRoles();
					$mdDialog.hide(data);
				}
			}],
      		templateUrl: 'templates/forms/create_role.html',
      		targetEvent: ev
		}).then(function(data) {
			User.creatRole(data);
			loadRoles();
		});
	}
}]);

sjControllers.controller('DashboardController', ['$scope', '$rootScope', '$state', '$mdSidenav', 'Task', 'Auth', 'User', 'UI', 
	function ($scope, $rootScope, $state, $mdSidenav, Task, Auth, User, UI) {
	'use strict';

	$rootScope.pageTitle = 'Dashboard';
	$scope.todos = [];

	UI.getSidebarItems().then(function(data) {
		$scope.sidebarItems = data;
	});

	function loadTodo() {
		User.getTodods($rootScope.loggedInUser.id).then(function(data) {
			$scope.todos = data;
		});
	}
	loadTodo();
	$scope.navigateTo = function(state) {
		$state.go(state);
	};

	$scope.togSideNav = function() {
		$mdSidenav('left').toggle();
	};

	$scope.addNewTodo = function(ev, newTodo) {
		User.addTodo({
			userId: $rootScope.loggedInUser.id,
			todo: newTodo
		});
		loadTodo();
		$state.go($state.current, {}, {reload: true});
		ev.preventDefault();
	};	

	$scope.userSelected = function(id, checkedTodo) {
		if(checkedTodo) {
			User.completeTodo({
				userId: $rootScope.loggedInUser.id,
				todoId: id
			}).then(function(statusCode) {
				$state.go($state.current, {}, {reload: true});				
			});			
		}
	};

	$scope.clearTodos = function() {
		User.clearTodos().then(function(statusCode) {
			$state.go($state.current, {}, {reload: true});				
		});	
	};
}]);
sjControllers.controller('GroupController', ['$scope', '$stateParams', '$state', '$rootScope', '$mdDialog', 'User', 
	function($scope, $stateParams, $state, $rootScope, $mdDialog, User){
	$rootScope.pageTitle = 'Group'
	
	function loadGroup() {
		User.getGroup($stateParams.groupId).then(function(data) {
			$scope.group = data;
		});
	}
	loadGroup();

	$scope.editGroup = function(ev) {
		$mdDialog.show({
			locals: {
				oldGroup: $scope.group
			},
			controller: ['$scope','$mdDialog', 'oldGroup', 'User', function($scope,$mdDialog,oldGroup, User) {
				$scope.group = oldGroup;				
				
				$scope.cancel = function() {
					loadGroup();
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {
					$mdDialog.hide(data);
				}
			}],
      		templateUrl: 'templates/forms/edit_group.html',
      		targetEvent: ev
		}).then(function(data) {
			User.editGroup(data);
			loadGroup();
		});
	};

	$scope.deleteGroup = function(ev) {
		var confirm = $mdDialog.confirm()
								.title('Do you really want to delete this group?')
								.content('This action is not recoverable')
								.ariaLabel('Delete Group Confirmation')
								.ok('Delete Group')
								.cancel('Calncel')
								.targetEvent(ev);
    	$mdDialog.show(confirm).then(function() {
    		User.deleteGroup($scope.group.id);    		    		
    		loadGroup();
    	}, function() {
    		
    	});
	};

	$scope.addUser = function(ev) {
		$mdDialog.show({
			locals: {
				oldGroup: $scope.group
			},
			controller: ['$scope','$mdDialog', 'oldGroup', 'User', function($scope,$mdDialog,oldGroup, User) {
				$scope.group = oldGroup;
				$scope.selectedUsers = [];
				User.getUsersForGroup($scope.group.id).then(function(data) {
					$scope.userList = [];			
					angular.forEach(data, function(val, key) {
						$scope.userList.push(val);
					});
				});

				$scope.userSelected = function(data, selected) {
					if(selected) {
						$scope.selectedUsers.push(data);
					} else {
						var indx = $scope.selectedUsers.indexOf(data);
						if(indx > -1) {
							$scope.selectedUsers.splice(indx,1);
						}
					}					
				}

				$scope.cancel = function() {
					loadGroup();
					$mdDialog.cancel();					
				}

				$scope.submit = function() {					
					$mdDialog.hide($scope.selectedUsers);
				}
			}],
      		templateUrl: 'templates/forms/add_users_to_group.html',
      		targetEvent: ev
		}).then(function(data) {
			console.log({groupId: $scope.group.id, users: data});
			User.addUserToGroup({groupId: $scope.group.id, users: data});
			loadGroup();
		});
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
sjControllers.controller('ProjectListController', ['$scope', '$rootScope', '$mdDialog', '$mdToast', 'Project', '$state', 
	function($scope, $rootScope, $mdDialog, $mdToast, Project, $state){
	$rootScope.pageTitle = 'Projects';
	$scope.chart = {
		labels: [],
		data: [],
		options: {
			responsive: true,
			barShowStroke : false,
			scaleShowVerticalLines: false,
			barValueSpacing: 20,
			maintainAspectRatio: true,
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
					data.tags = $scope.tagstring.split(/\s*,\s*/);										
					$mdDialog.hide(data);
				}

				$scope.makeSlug = function(str) {
					if(str) {
						$scope.project.slug = str.toLowerCase()
											.replace(/[^\w ]+/g,'')
											.replace(/ +/g,'-');
					}
				}; 
			}],
      		templateUrl: 'templates/forms/create_project.html',
      		targetEvent: ev,
		}).then(function(data) {			
			Project.createProject(data);			
			$state.go($state.current, {}, {reload: true});			
		});
	};
}]);
sjControllers.controller('ProjectsController', ['$scope', '$rootScope', '$stateParams', '$mdDialog', 'Project', 'User', 
	function($scope, $rootScope, $stateParams, $mdDialog, Project, User) {

	$scope.project = {};	
	$scope.chart = {
		labels: [],		
		chartData: [],
		series: ['Desired', 'Solved'],
		options: {
			responsive: true,
			barValueSpacing : 75,			
			barDatasetSpacing : 30,
		}		
	}



	Project.getProjectBySlug($stateParams.projectSlug).then(function(data) {
		$scope.project = data;
		$scope.deadline = moment(data.deadline).calendar();
		$rootScope.pageTitle = data.name;

		User.getUserById(data.project_manager_id).then(function(manager) {
			$scope.project_manager = manager;
		});
		

		$scope.editUsers = function(ev) {

		$mdDialog.show({
			locals: {
				projectId: $scope.project.id
			},
			controller: ['$scope','$mdDialog', 'projectId', 'User', function($scope,$mdDialog,projectId,User) {
				$scope.project = [];
				$scope.allUsers = [];
				$scope.selectedUsers = [];
				$scope.s2 = true;
				Project.getProjectById(projectId).then(function(proj) {
					$scope.project = proj;					
					User.getRawUsers().then(function(data) {						
						$scope.allUsers = data;						
					});
				});		


				$scope.usersChanged = function(data, selected) {
					if(selected) {
						$scope.selectedUsers.push(data);
					} else {
						var indx = $scope.selectedUsers.indexOf(data);
						if(indx > -1) {
							$scope.selectedUsers.splice(indx,1);
						}
					}
				}

				$scope.cancel = function() {					
					$mdDialog.cancel();					
				}

				$scope.submit = function() {
					$mdDialog.hide($scope.selectedUsers);
				}
			}],
      		templateUrl: 'templates/forms/edit_project_users.html',
      		targetEvent: ev
		}).then(function(data) {			
			Project.addUserToProject({id: $scope.project.id, users: data});
		});

		};

		Project.getProjectVelocity($scope.project.id).then(function(data) {
			var totals = [];
			var actuals = [];
			
			angular.forEach(data, function(sprint) {							
				$scope.chart.labels.push(sprint.name);				
				totals.push(sprint.total_complexity);
				actuals.push(sprint.solved_complexity);
			});
			$scope.chart.chartData.push(totals);
			$scope.chart.chartData.push(actuals);
		});

		Project.getProjectSprintStatus(data.id).then(function(data) {			
			$scope.sprints = data;
		});
	});	
}]);
sjControllers.controller('RoleController', ['$scope', '$stateParams', '$state', '$rootScope', '$mdDialog', 'User', 'Permission', 
	function($scope, $stateParams, $state, $rootScope, $mdDialog, User, Permission){
	$rootScope.pageTitle = 'Role'
	$rootScope.permissions = {};

	function loadRole() {
		User.getRole($stateParams.roleId).then(function(data) {
			$scope.role = data;

			Permission.getRolePermissions(data.id).then(function(roles) {
				$scope.permissions = roles;
			});
		});
	}
	loadRole();

	

	$scope.editRole = function(ev) {
		$mdDialog.show({
			locals: {
				oldRole: $scope.role
			},
			controller: ['$scope','$mdDialog', 'oldRole', 'User', function($scope,$mdDialog,oldRole, User) {
				$scope.role = oldRole;				
				
				$scope.cancel = function() {
					loadRole();
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {
					$mdDialog.hide(data);
				}
			}],
      		templateUrl: 'templates/forms/edit_role.html',
      		targetEvent: ev
		}).then(function(data) {
			User.editRole(data);
			loadRole();
		});
	};

	$scope.editPermission = function(perm, grant) {
		Permission.setPermission({
			permission: perm,
			roleId: $scope.role.id,
			granted: grant
		}).then(function(status) {
			console.log(status);
			Permission.getUserPermissions($rootScope.loggedInUser.id).then(function(perms) {				
				console.log(perms);
				Permission.cachePermissions(perms);
			});
			loadRole();			
		});
	}

	$scope.deleteRole = function(ev) {
		var confirm = $mdDialog.confirm()
								.title('Do you really want to delete this role?')
								.content('This action is not recoverable')
								.ariaLabel('Delete Role Confirmation')
								.ok('Delete ROle')
								.cancel('Calncel')
								.targetEvent(ev);
    	$mdDialog.show(confirm).then(function() {
    		User.deleteRole($scope.role.id);    		    		
    		$state.go('dashboard.roles');
    	}, function() {
    		
    	});
	};
}]);
sjControllers.controller('SprintController', ['$scope', '$rootScope', '$stateParams', '$state', 'Sprint', 'User', 'Project',
 function($scope, $rootScope, $stateParams, $state, Sprint, User, Project){
	$rootScope.pageTitle = 'Sprint'
	$scope.sprint = [];
	$scope.project = [];

	$scope.chart = {
		labels: [],
		series: ['Ideal velocity', 'Current velocity'],
		data: [],
		options: {
			responsive: true,											
		}		
	}


	Sprint.getSprintById($stateParams.sprintId).then(function(data) {
		data.deadline = new Date(data.deadline.replace(/-/g,"/"));		
		$scope.sprint = data;
		Project.getProjectById($scope.sprint.project_id).then(function(proj) {
			$scope.project = proj;
		});

		for (var date = moment($scope.sprint.created_at); date.isBefore(moment($scope.sprint.deadline)); date.add(1, 'day')) {
			$scope.chart.labels.push(date.format('D MMM'));
		};

		Sprint.getSprintBurnDown($scope.sprint.id).then(function(data) {				
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
	});




}])
sjControllers.controller('SprintsController', ['$scope', '$stateParams', '$mdDialog', '$state', 'Project', 'Task', 'Sprint',
 function($scope, $stateParams, $mdDialog, $state, Project, Task, Sprint){	 	

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
			$scope.sprints = [];
			angular.forEach(data, function(sprint) {
				var totalTasks = 0;
				sprint.deadline = new Date(sprint.deadline.replace(/-/g,"/"));
				$scope.sprints.push(sprint);
				angular.forEach(sprint.tasks,function(task) {
					totalTasks += 1;
				});				
			});			
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

	$scope.createSprint = function(ev) {
		$mdDialog.show({
			locals: {
				project: $scope.project,
				backlog: $scope.selectedBacklogTasks
			},
			controller: ['$scope','$mdDialog', 'project', 'backlog', 'Sprint', function($scope,$mdDialog,project,backlog,Sprint) {				

				$scope.tasks = project.tasks;
				$scope.backlogTasks = backlog;				
				$scope.workflows = [];
				

				$scope.cancel = function() {					
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {
					data.project_id = project.id;
					data.tasks = $scope.backlogTasks;
					$mdDialog.hide(data);
				}

				$scope.makeSlug = function(str) {
					$scope.task.slug = str.toLowerCase()
											.replace(/[^\w ]+/g,'')
											.replace(/ +/g,'-');
				}; 
			}],
      		templateUrl: 'templates/forms/create_sprint.html',
      		targetEvent: ev
		}).then(function(data) {
			console.log(data);
			Sprint.createSprint(data);			
			$state.go($state.current, {}, {reload: true});
		});
	}

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
			$state.go($state.current, {}, {reload: true});
		});
	};
}]);
sjControllers.controller('UserController', ['$scope', '$rootScope', '$stateParams', '$mdDialog', 'User', 'Permission', 
 function($scope, $rootScope, $stateParams, $mdDialog, User, Permission){

	function loadUser() {
		User.getUserById($stateParams.userId).then(function(data) {
			$scope.user = data;
			User.getRole(data.role_id).then(function(data) {
				$scope.user_role = data;
			});
			Permission.getUserPermissions($scope.user.id).then(function(perms) {
				$scope.permissions = perms;
			})
		});
	}
	loadUser();

	$scope.editPermission = function(perm, grant) {
		Permission.setPermission({
			permission: perm,
			userId: $scope.user.id,
			granted: grant
		}).then(function(status) {
			Permission.getUserPermissions($scope.user.id).then(function(perms) {
				Permission.cachePermissions(perms);
			});			
			
			loadRole();		
		});
	}

	$scope.editUser = function(ev) {
		$mdDialog.show({
			locals: {
				oldUser: $scope.user,
				user_role: $scope.user_role
			},
			controller: ['$scope','$mdDialog', 'oldUser', 'User', 'user_role', function($scope,$mdDialog,oldUser,User,user_role) {
				$scope.user = oldUser;				
				$scope.role_id = user_role.id;
				
				User.getAllRoles().then(function(data) {
					$scope.allRoles = data;
				});

				$scope.cancel = function() {
					loadUser();
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {
					data.id = oldUser.id;
					$mdDialog.hide(data);
				}
			}],
      		templateUrl: 'templates/forms/edit_user.html',
      		targetEvent: ev
		}).then(function(data) {			
			User.editUser(data);
			$state.go($state.current, {}, {reload: true});
		});
	};

}]);
sjControllers.controller('WorkspaceController', ['$scope', '$rootScope', '$state', '$stateParams', 'User', 'Sprint', 'Project', 
	function($scope, $rootScope, $state, $stateParams, User, Sprint, Project){
	$rootScope.pageTitle = "Workspace";
	$scope.sprints = {};
	$scope.projects = {};
	$scope.currentSprint = [];
	$scope.currentSprintId = $stateParams.sprintId;	
	$scope.workflowStages = [];
	Project.getProjects($rootScope.loggedInUser.id).then(function(data) {				
		$scope.projects = data;	
	});

	$scope.projectSelected = function(pro) {
		Sprint.getSprintsOfProject(pro).then(function(data) {
			$scope.sprints = data;
		});
	};

	$scope.sprintChanged = function(sprint) {		
		$state.go($state.current, {sprintId: sprint}, {reload: true});
	}

	$scope.isLast = function(num) {
		if(num == 0) {
			return false;
		} else {
			return true;
		}
	}

	if($scope.currentSprintId != null) {
		Sprint.getSprintById($scope.currentSprintId).then(function(data) {
			$scope.currentSprint = data;						
			Sprint.getWorkflowStages(data.workflow.id).then(function(stages) {
				$scope.workflowStages = stages;
				console.log($scope.workflowStages);
			});
		});
	}

	$scope.tranferTask = function(stageId, taskId) {
		var formData = {
			workflow_id: $scope.currentSprint.workflow.id,
			stage_id: stageId,
			task_id: taskId
		}
		Sprint.tranferTask(formData).then(function() {
			$state.go($state.current, {sprintId: $scope.currentSprintId}, {reload: true});
		});			
	}
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
		replace: true		
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
					locals: {
						user: $scope.user
					},
					controller: ['$scope', '$rootScope', 'user', function ($scope, $rootScope, user) {
						$scope.optionItems = [
							{
								name: 'Profile',
								link: '#/users/' + user.id
							},							
						];
						if(user.id == $rootScope.loggedInUser.id) {
							$scope.optionItems.push({
								name: 'Logout',
								link: '#/logout'
							});
						}
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
		}
	}])
	.constant('softjobConfig', {
		APP_BACKEND: window.location.protocol + '//internal.' + window.location.host
	});