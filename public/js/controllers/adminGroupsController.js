sjControllers.controller('AdminGroupsController', ['$scope', '$rootScope', '$mdDialog', 'User', 
	function($scope, $rootScope, $mdDialog, User){
	$rootScope.pageTitle = 'Admin';
	
	function loadGroups() {
		User.getAllGroups().then(function(data) {
			$scope.groups = data;
		});
	}
	loadGroups();

	$scope.createGroup = function(ev) {
		$mdDialog.show({			
			controller: ['$scope','$mdDialog', 'User', function($scope,$mdDialog,User) {								
				
				$scope.cancel = function() {
					loadGroups();
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {					
					loadGroups();
					$mdDialog.hide(data);
				}
			}],
      		templateUrl: 'templates/forms/create_group.html',
      		targetEvent: ev
		}).then(function(data) {
			User.createGroup(data);
			loadGroups();
		});
	}
}]);