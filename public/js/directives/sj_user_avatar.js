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
					controller: ['$scope', 'User', function ($scope, User) {
						$scope.optionItems = [
							{
								name: 'Profile Settings',
								icon: 'ion-gear-b'
							},
							{
								name: 'Logout',
								icon: 'ion-gear-b'
							}
						];
					}]
				});
			};
		}],
		templateUrl: 'directives/user_avatar.html'
	};
}]);