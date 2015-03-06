sjControllers.controller('AdminRolesController', ['$scope', '$rootScope', '$mdDialog', 'User', function($scope, $rootScope, $mdDialog, User){
	$rootScope.pageTitle = 'Admin';
	
	function loadRoles() {
		User.getAllRoles().then(function(data) {
			$scope.roles = data;
		});
	}
	loadRoles();

	$scope.createRole = function(ev) {
		$mdDialog.show({			
			controller: ['$scope','$mdDialog', 'User', function($scope,$mdDialog,User) {								
				
				$scope.cancel = function() {
					loadRoles();
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {					
					loadRoles();
					$mdDialog.hide(data);
				}
			}],
      		templateUrl: 'templates/forms/create_role.html',
      		targetEvent: ev
		}).then(function(data) {
			User.creatRole(data);
			loadRoles();
		});
	}
}]);