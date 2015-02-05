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