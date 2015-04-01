sjServices.factory('Product', ['$http', '$q', '$state', '$mdToast', 'softjobConfig', function($http, $q, $state, $mdToast, softjobConfig){
	var serviceInstance = {};

	serviceInstance.getAllProducts = function() {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/products'
		}).success(function(data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject(status);
		});

		return deferred.promise;
	};

	serviceInstance.getProductById = function(productId) {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/product/' + productId
		}).success(function(data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject(status);
		});

		return deferred.promise;
	}

	serviceInstance.createProduct = function(formData) {
		$http({
			method: 'post',
			url: softjobConfig.APP_BACKEND + '/products',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			$mdToast.show($mdToast.simple().content("New product is created"));			
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	};

	serviceInstance.createIssue = function(formData) {
		$http({
			method: 'post',
			url: softjobConfig.APP_BACKEND + '/issues',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {			
			$mdToast.show($mdToast.simple().content("New product is created"));			
		}).error(function (data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
		});
	}

	serviceInstance.getIssueStages = function() {
		var deferred = $q.defer();
		$http({
			method: 'get',
			url: softjobConfig.APP_BACKEND + '/issues/stages'
		}).success(function(data, status, headers, config) {
			deferred.resolve(data);
		}).error(function(data, status, headers, config) {
			$mdToast.show($mdToast.simple().content(data.message));
			deferred.reject(status);
		});

		return deferred.promise;
	}

	serviceInstance.tranferIssue = function(formData) {
		var deferred = $q.defer();
		$http({
			method: 'patch',
			url: softjobConfig.APP_BACKEND + '/issue/tranfer',
			data: formData,
			headers: { 'Content-Type': 'application/json' }
		}).success(function (data, status, headers, config) {
			deferred.resolve(status);
			$mdToast.show($mdToast.simple().content("Issue state changed"));			
		}).error(function (data, status, headers, config) {
			deferred.resolve(status);
			$mdToast.show($mdToast.simple().content(data.message));
		});
		return deferred.promise;
	}

	return serviceInstance;
}])