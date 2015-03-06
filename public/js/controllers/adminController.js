sjControllers.controller('AdminController', ['$scope', '$rootScope', '$mdDialog', 'User', function($scope, $rootScope, $mdDialog, User) {
	$rootScope.pageTitle = "Admin";
	function loadUsers() {
		User.getAllUsers().then(function(data) {
			$scope.usersdata = data;
		});
	}
	
	loadUsers();	

	$scope.createUser = function(ev) {		
		$mdDialog.show({			
			locals: {
				usersdata: $scope.usersdata
			},
			controller: ['$scope','$mdDialog', 'User', 'usersdata', function($scope,$mdDialog,User,usersdata) {
				$scope.usersdata = usersdata;
				
				
				$scope.cancel = function() {
					loadUsers();
					$mdDialog.cancel();
				}

				$scope.submit = function(data) {
					loadUsers();
					data.organization_id = 1;
					$mdDialog.hide(data);
				}
			}],
      		templateUrl: 'templates/forms/create_user.html',
      		targetEvent: ev
		}).then(function(data) {			
			User.createUser(data);
			loadUsers();
		});
	}
}]);