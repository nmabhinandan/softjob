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