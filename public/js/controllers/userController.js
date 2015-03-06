sjControllers.controller('UserController', ['$scope', '$rootScope', '$stateParams', '$mdDialog', 'User',
 function($scope, $rootScope, $stateParams, $mdDialog, User){
	
	function loadUser() {
		User.getUserById($stateParams.userId).then(function(data) {
			$scope.user = data;
			User.getRole(data.role_id).then(function(data) {
				$scope.user_role = data;
			});		
		});
	}
	loadUser();

	$scope.editUser = function(ev) {
		$mdDialog.show({
			locals: {
				oldUser: $scope.user,
				user_role: $scope.user_role
			},
			controller: ['$scope','$mdDialog', 'oldUser', 'User', 'user_role', function($scope,$mdDialog,oldUser,User,user_role) {
				$scope.user = oldUser;				
				$scope.role_id = user_role.id;
				
				User.getAllRoles().then(function(data) {
					$scope.allRoles = data;
				});

				$scope.cancel = function() {
					loadUser();
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {
					data.id = oldUser.id;
					$mdDialog.hide(data);
				}
			}],
      		templateUrl: 'templates/forms/edit_user.html',
      		targetEvent: ev
		}).then(function(data) {			
			console.log(data);
			User.editUser(data);
			$state.go($state.current, {}, {reload: true});
		});
	};

}]);