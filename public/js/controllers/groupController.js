sjControllers.controller('GroupController', ['$scope', '$stateParams', '$state', '$rootScope', '$mdDialog', 'User', 
	function($scope, $stateParams, $state, $rootScope, $mdDialog, User){
	$rootScope.pageTitle = 'Group'
	
	function loadGroup() {
		User.getGroup($stateParams.groupId).then(function(data) {
			$scope.group = data;
		});
	}
	loadGroup();

	$scope.editGroup = function(ev) {
		$mdDialog.show({
			locals: {
				oldGroup: $scope.group
			},
			controller: ['$scope','$mdDialog', 'oldGroup', 'User', function($scope,$mdDialog,oldGroup, User) {
				$scope.group = oldGroup;				
				
				$scope.cancel = function() {
					loadGroup();
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {
					$mdDialog.hide(data);
				}
			}],
      		templateUrl: 'templates/forms/edit_group.html',
      		targetEvent: ev
		}).then(function(data) {
			User.editGroup(data);
			loadGroup();
		});
	};

	$scope.deleteGroup = function(ev) {
		var confirm = $mdDialog.confirm()
								.title('Do you really want to delete this group?')
								.content('This action is not recoverable')
								.ariaLabel('Delete Group Confirmation')
								.ok('Delete Group')
								.cancel('Calncel')
								.targetEvent(ev);
    	$mdDialog.show(confirm).then(function() {
    		User.deleteGroup($scope.group.id);    		    		
    		loadGroup();
    	}, function() {
    		
    	});
	};

	$scope.addUser = function(ev) {
		$mdDialog.show({
			locals: {
				oldGroup: $scope.group
			},
			controller: ['$scope','$mdDialog', 'oldGroup', 'User', function($scope,$mdDialog,oldGroup, User) {
				$scope.group = oldGroup;
				$scope.selectedUsers = [];
				User.getUsersForGroup($scope.group.id).then(function(data) {
					$scope.userList = [];			
					angular.forEach(data, function(val, key) {
						$scope.userList.push(val);
					});
				});

				$scope.userSelected = function(data, selected) {
					if(selected) {
						$scope.selectedUsers.push(data);
					} else {
						var indx = $scope.selectedUsers.indexOf(data);
						if(indx > -1) {
							$scope.selectedUsers.splice(indx,1);
						}
					}					
				}

				$scope.cancel = function() {
					loadGroup();
					$mdDialog.cancel();					
				}

				$scope.submit = function() {					
					$mdDialog.hide($scope.selectedUsers);
				}
			}],
      		templateUrl: 'templates/forms/add_users_to_group.html',
      		targetEvent: ev
		}).then(function(data) {
			console.log({groupId: $scope.group.id, users: data});
			User.addUserToGroup({groupId: $scope.group.id, users: data});
			loadGroup();
		});
	};
}]);