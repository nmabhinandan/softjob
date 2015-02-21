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