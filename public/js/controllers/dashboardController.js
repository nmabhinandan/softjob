sjControllers.controller('DashboardController', ['$scope', '$state', 'Task', 'Auth', 'User', 'UI', function ($scope, $state, Task, Auth, User, UI) {
	'use strict';

	$scope.pageTitle = 'Dashboard';
	UI.getSidebarItems().then(function(data) {
		$scope.sidebarItems = data;
	});
	
	$scope.navigateTo = function(state) {
		$state.go(state);
	};
}]);