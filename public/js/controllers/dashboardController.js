sjControllers.controller('DashboardController', ['$scope', '$rootScope', '$state', 'Task', 'Auth', 'User', 'UI', function ($scope, $rootScope, $state, Task, Auth, User, UI) {
	'use strict';

	$rootScope.pageTitle = 'Dashboard';
	
	UI.getSidebarItems().then(function(data) {
		$scope.sidebarItems = data;
	});
	
	$scope.navigateTo = function(state) {
		$state.go(state);
	};
}]);