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

	service.getQuote = function() {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/quote',
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise;
	}

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
