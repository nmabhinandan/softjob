sjControllers.controller('LoginController', ['$scope', 'Auth', function ($scope, Auth) {
	'use strict';
	$scope.submit = function(user) {
		Auth.login(user);
	};
}]);