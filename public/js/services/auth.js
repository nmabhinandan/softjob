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