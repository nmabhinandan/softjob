sjServices.factory('Permission', ['$http', '$state', '$rootScope', '$mdToast', '$window', '$q', 'softjobConfig',
 function($http, $state, $rootScope, $mdToast, $window, $q, softjobConfig){
	var userPermissions = null;

	var instance = {};

	instance.getUserPermissions = function(userId) {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/permissions/of/user/' + userId
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise;
	};

	instance.getRolePermissions = function(roleId) {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/permissions/of/role/' + roleId
		}).success(function (data,status,headers,config) {
			deferred.resolve(data);
		}).error(function (data,status,headers,config) {
			deferred.reject(data);
		});
		return deferred.promise;
	};

	instance.setPermission = function(formData) {
		var deferred = $q.defer();
		$http({
			method: 'post',
			url: softjobConfig.APP_BACKEND + '/permissions',
			data: formData, 
			headers: { 'Content-Type': 'application/json' }
		}).success(function(data,status,headers,config) {
			$mdToast.show($mdToast.simple().content("Permissions chaned"));
			deferred.resolve(status);
		}).error(function(data,status,headers,config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject(status);
		});
		return deferred.promise;
	};

	instance.checkPermission = function(permission) {

		if(userPermissions == null) {			
			if($window.localStorage.getItem('softjob.permissions') === null) {				
				instance.getUserPermissions().then(function(data) {

					instance.cachePermissions(data);
					return instance.checkPermission(permission);
				});
			} else {				
				userPermissions = JSON.parse($window.localStorage.getItem('softjob.permissions'));
			}			
		}
		var flag = false;
		angular.forEach(userPermissions, function(perm) {			
			if(perm.permission === permission && perm.granted === true) {
				flag = true;
			}
		});
		return flag;
	}

	instance.cachePermissions = function(perms) {
		userPermissions = perms;
		$window.localStorage.setItem('softjob.permissions', JSON.stringify(perms));
	}

	return instance;
}]);