sjDirectives.directive('sjUserAvatar', [function () {
	return {
		restrict: 'E',
		replace: true,
		scope: {
			user: '='
		},
		controller: ['$scope', '$mdBottomSheet', function ($scope, $mdBottomSheet) {

			$scope.showOptions = function () {
				
				$mdBottomSheet.show({
					templateUrl: 'directives/user_avatar.options.html',
					locals: {
						user: $scope.user
					},
					controller: ['$scope', '$rootScope', 'user', function ($scope, $rootScope, user) {
						$scope.optionItems = [
							{
								name: 'Profile',
								link: '#/users/' + user.id
							},							
						];
						if(user.id == $rootScope.loggedInUser.id) {
							$scope.optionItems.push({
								name: 'Logout',
								link: '#/logout'
							});
						}
					}]
				});				
			};
		}],
		templateUrl: 'directives/user_avatar.html'
	};
}]);