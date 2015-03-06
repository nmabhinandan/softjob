sjControllers.controller('WorkspaceController', ['$scope', '$rootScope', '$state', '$stateParams', 'User', 'Sprint', 'Project', 
	function($scope, $rootScope, $state, $stateParams, User, Sprint, Project){
	$rootScope.pageTitle = "Workspace";
	$scope.sprints = {};
	$scope.projects = {};
	$scope.currentSprint = [];
	$scope.currentSprintId = $stateParams.sprintId;	
	$scope.workflowStages = [];
	Project.getProjects($rootScope.loggedInUser.id).then(function(data) {				
		$scope.projects = data;	
	});

	$scope.projectSelected = function(pro) {
		Sprint.getSprintsOfProject(pro).then(function(data) {
			$scope.sprints = data;
		});
	};

	$scope.sprintChanged = function(sprint) {		
		$state.go($state.current, {sprintId: sprint}, {reload: true});
	}

	$scope.isLast = function(num) {
		if(num == 0) {
			return false;
		} else {
			return true;
		}
	}

	if($scope.currentSprintId != null) {
		Sprint.getSprintById($scope.currentSprintId).then(function(data) {
			$scope.currentSprint = data;						
			Sprint.getWorkflowStages(data.workflow.id).then(function(stages) {
				$scope.workflowStages = stages;
				console.log($scope.workflowStages);
			});
		});
	}

	$scope.tranferTask = function(stageId, taskId) {
		var formData = {
			workflow_id: $scope.currentSprint.workflow.id,
			stage_id: stageId,
			task_id: taskId
		}
		Sprint.tranferTask(formData).then(function() {
			$state.go($state.current, {sprintId: $scope.currentSprintId}, {reload: true});
		});			
	}
}]);