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