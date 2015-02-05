sjServices.factory('Task', ['$http', 'softjobConfig', 'User', function ($http, softjobConfig, User) {
	'use strict';
	var service = {};
		service.getTasks = function () {
		return ['Task1', 'Task2'];
	};
	return service;
}]);