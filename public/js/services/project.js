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