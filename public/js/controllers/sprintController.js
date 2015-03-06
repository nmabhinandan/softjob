sjControllers.controller('SprintController', ['$scope', '$rootScope', '$stateParams', '$state', 'Sprint', 'User', 'Project',
 function($scope, $rootScope, $stateParams, $state, Sprint, User, Project){
	$rootScope.pageTitle = 'Sprint'
	$scope.sprint = [];
	$scope.project = [];

	$scope.chart = {
		labels: [],
		series: ['Ideal velocity', 'Current velocity'],
		data: [],
		options: {
			responsive: true,											
		}		
	}


	Sprint.getSprintById($stateParams.sprintId).then(function(data) {
		data.deadline = new Date(data.deadline.replace(/-/g,"/"));		
		$scope.sprint = data;
		Project.getProjectById($scope.sprint.project_id).then(function(proj) {
			$scope.project = proj;
		});

		for (var date = moment($scope.sprint.created_at); date.isBefore(moment($scope.sprint.deadline)); date.add(1, 'day')) {
			$scope.chart.labels.push(date.format('D MMM'));
		};

		Sprint.getSprintBurnDown($scope.sprint.id).then(function(data) {				
			var velocity = [];
			var idealVelocity = [];
			
			angular.forEach(data.ideal_velocity,function(value) {				
				idealVelocity.push(value);
			});
			$scope.chart.data.push(idealVelocity);
			
			angular.forEach(data.current_velocity,function(value) {
				velocity.push(value);
			});			
			$scope.chart.data.push(velocity);						
		});
	});




}])