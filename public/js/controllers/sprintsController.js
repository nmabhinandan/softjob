sjControllers.controller('SprintsController', ['$scope', '$stateParams', '$mdDialog', '$state', 'Project', 'Task', 'Sprint',
 function($scope, $stateParams, $mdDialog, $state, Project, Task, Sprint){	 	

 	var backlogChecks = 0;
 	$scope.selectedBacklogTasks = [];	

	Project.getProjectById($stateParams.projectId).then(function(data) {
		$scope.project = data;
		
		$scope.pageTitle = data.name;
		getTasksOfProject();
		getSprintsOfProject()
	});

	

	function getTasksOfProject() {
		Task.getTasksOfProject($scope.project.id).then(function(data) {
			var freeTasks = [];
			var allTasks = [];
			angular.forEach(data,function(value) {
				allTasks.push(value);
				if(value.sprint_id === null) {
					freeTasks.push(value);
				}
				$scope.project.tasks = allTasks;
				$scope.project.freeTasks = freeTasks;
			});			
		});
	}

	function getSprintsOfProject() {
		Sprint.getSprintsOfProject($scope.project.id).then(function(data) {
			$scope.sprints = [];
			angular.forEach(data, function(sprint) {
				var totalTasks = 0;
				sprint.deadline = new Date(sprint.deadline.replace(/-/g,"/"));
				$scope.sprints.push(sprint);
				angular.forEach(sprint.tasks,function(task) {
					totalTasks += 1;
				});				
			});			
		});		
	}

	$scope.backlogChanged = function(taskId, state) {		
		if(state) {
			backlogChecks += 1;
			$scope.selectedBacklogTasks.push(taskId);
		} else {
			backlogChecks -= 1;
			var indx = $scope.selectedBacklogTasks.indexOf(taskId);
			if(indx > -1) {
				$scope.selectedBacklogTasks.splice(indx,1);
			}
		}		
	};

	$scope.createSprint = function(ev) {
		$mdDialog.show({
			locals: {
				project: $scope.project,
				backlog: $scope.selectedBacklogTasks
			},
			controller: ['$scope','$mdDialog', 'project', 'backlog', 'Sprint', function($scope,$mdDialog,project,backlog,Sprint) {				

				$scope.tasks = project.tasks;
				$scope.backlogTasks = backlog;				
				$scope.workflows = [];
				

				$scope.cancel = function() {					
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {
					data.project_id = project.id;
					data.tasks = $scope.backlogTasks;
					$mdDialog.hide(data);
				}

				$scope.makeSlug = function(str) {
					$scope.task.slug = str.toLowerCase()
											.replace(/[^\w ]+/g,'')
											.replace(/ +/g,'-');
				}; 
			}],
      		templateUrl: 'templates/forms/create_sprint.html',
      		targetEvent: ev
		}).then(function(data) {
			console.log(data);
			Sprint.createSprint(data);			
			$state.go($state.current, {}, {reload: true});
		});
	}

	$scope.isBacklogChecked = function() {
		return (backlogChecks > 0) ? true : false;
	};

	$scope.createTask = function(ev) {
		$mdDialog.show({
			locals: {
				project: $scope.project
			},
			controller: ['$scope','$mdDialog', 'project', function($scope,$mdDialog,project) {
				$scope.tasks = project.tasks;				
				$scope.cancel = function() {					
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {
					data.Project_id = project.id;
					$mdDialog.hide(data);
				}

				$scope.makeSlug = function(str) {
					$scope.task.slug = str.toLowerCase()
											.replace(/[^\w ]+/g,'')
											.replace(/ +/g,'-');
				}; 
			}],
      		templateUrl: 'templates/forms/create_task.html',
      		targetEvent: ev
		}).then(function(data) {
			Task.createTask(data);			
			$state.go($state.current, {}, {reload: true});
		});
	};
}]);