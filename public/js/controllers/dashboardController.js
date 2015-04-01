sjControllers.controller('DashboardController', ['$scope', '$rootScope', '$state', '$mdSidenav', 'Task', 'Auth', 'User', 'UI',
	function ($scope, $rootScope, $state, $mdSidenav, Task, Auth, User, UI) {
	'use strict';

	$rootScope.pageTitle = 'Dashboard';
	$scope.todos = [];

	UI.getSidebarItems().then(function(data) {
		$scope.sidebarItems = data;
	});

	User.getQuote().then(function(data) {
		$scope.quote = data;
	});

	function loadTodo() {
		User.getTodods($rootScope.loggedInUser.id).then(function(data) {
			$scope.todos = data;
		});
	}
	loadTodo();
	$scope.navigateTo = function(state) {
		$state.go(state);
	};

	$scope.togSideNav = function() {
		$mdSidenav('left').toggle();
	};

	$scope.addNewTodo = function(ev, newTodo) {
		User.addTodo({
			userId: $rootScope.loggedInUser.id,
			todo: newTodo
		});
		loadTodo();
		// $state.go($state.current, {}, {reload: true});
		ev.preventDefault();
	};

	$scope.userSelected = function(id, checkedTodo) {
		if(checkedTodo) {
			User.completeTodo({
				userId: $rootScope.loggedInUser.id,
				todoId: id
			}).then(function(statusCode) {
				$state.go($state.current, {}, {reload: true});
			});
		}
	};

	$scope.clearTodos = function() {
		User.clearTodos().then(function(statusCode) {
			$state.go($state.current, {}, {reload: true});
		});
	};
}]);
