sjControllers.controller('ProjectsController', ['$scope', '$rootScope', '$stateParams', '$mdDialog', 'Project', 'User', 
	function($scope, $rootScope, $stateParams, $mdDialog, Project, User) {

	$scope.project = {};	
	$scope.chart = {
		labels: [],		
		chartData: [],
		series: ['Desired', 'Solved'],
		options: {
			responsive: true,
			barValueSpacing : 75,			
			barDatasetSpacing : 30,
		}		
	}



	Project.getProjectBySlug($stateParams.projectSlug).then(function(data) {
		$scope.project = data;
		$scope.deadline = moment(data.deadline).calendar();
		$rootScope.pageTitle = data.name;

		User.getUserById(data.project_manager_id).then(function(manager) {
			$scope.project_manager = manager;
		});
		

		$scope.editUsers = function(ev) {

		$mdDialog.show({
			locals: {
				projectId: $scope.project.id
			},
			controller: ['$scope','$mdDialog', 'projectId', 'User', function($scope,$mdDialog,projectId,User) {
				$scope.project = [];
				$scope.allUsers = [];
				$scope.selectedUsers = [];
				$scope.s2 = true;
				Project.getProjectById(projectId).then(function(proj) {
					$scope.project = proj;					
					User.getRawUsers().then(function(data) {						
						$scope.allUsers = data;						
					});
				});		


				$scope.usersChanged = function(data, selected) {
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
					$mdDialog.cancel();					
				}

				$scope.submit = function() {
					$mdDialog.hide($scope.selectedUsers);
				}
			}],
      		templateUrl: 'templates/forms/edit_project_users.html',
      		targetEvent: ev
		}).then(function(data) {			
			Project.addUserToProject({id: $scope.project.id, users: data});
		});

		};

		Project.getProjectVelocity($scope.project.id).then(function(data) {
			var totals = [];
			var actuals = [];
			
			angular.forEach(data, function(sprint) {							
				$scope.chart.labels.push(sprint.name);				
				totals.push(sprint.total_complexity);
				actuals.push(sprint.solved_complexity);
			});
			$scope.chart.chartData.push(totals);
			$scope.chart.chartData.push(actuals);
		});

		Project.getProjectSprintStatus(data.id).then(function(data) {			
			$scope.sprints = data;
		});
	});	
}]);