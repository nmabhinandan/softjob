sjControllers.controller('RoleController', ['$scope', '$stateParams', '$state', '$rootScope', '$mdDialog', 'User', 'Permission', 
	function($scope, $stateParams, $state, $rootScope, $mdDialog, User, Permission){
	$rootScope.pageTitle = 'Role'
	$rootScope.permissions = {};

	function loadRole() {
		User.getRole($stateParams.roleId).then(function(data) {
			$scope.role = data;

			Permission.getRolePermissions(data.id).then(function(roles) {
				$scope.permissions = roles;
			});
		});
	}
	loadRole();

	

	$scope.editRole = function(ev) {
		$mdDialog.show({
			locals: {
				oldRole: $scope.role
			},
			controller: ['$scope','$mdDialog', 'oldRole', 'User', function($scope,$mdDialog,oldRole, User) {
				$scope.role = oldRole;				
				
				$scope.cancel = function() {
					loadRole();
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {
					$mdDialog.hide(data);
				}
			}],
      		templateUrl: 'templates/forms/edit_role.html',
      		targetEvent: ev
		}).then(function(data) {
			User.editRole(data);
			loadRole();
		});
	};

	$scope.editPermission = function(perm, grant) {
		Permission.setPermission({
			permission: perm,
			roleId: $scope.role.id,
			granted: grant
		}).then(function(status) {
			console.log(status);
			Permission.getUserPermissions($rootScope.loggedInUser.id).then(function(perms) {				
				console.log(perms);
				Permission.cachePermissions(perms);
			});
			loadRole();			
		});
	}

	$scope.deleteRole = function(ev) {
		var confirm = $mdDialog.confirm()
								.title('Do you really want to delete this role?')
								.content('This action is not recoverable')
								.ariaLabel('Delete Role Confirmation')
								.ok('Delete ROle')
								.cancel('Calncel')
								.targetEvent(ev);
    	$mdDialog.show(confirm).then(function() {
    		User.deleteRole($scope.role.id);    		    		
    		$state.go('dashboard.roles');
    	}, function() {
    		
    	});
	};
}]);