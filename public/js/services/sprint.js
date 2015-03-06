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