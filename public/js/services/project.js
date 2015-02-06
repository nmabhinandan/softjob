sjServices.factory('Project', ['User', '$http', '$q', '$mdToast', 'softjobConfig', function(User, $http, $q, $mdToast, softjobConfig){
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

	return instance;
}]);