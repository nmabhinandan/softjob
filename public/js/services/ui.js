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