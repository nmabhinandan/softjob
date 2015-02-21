sjControllers.controller('ProjectsController', ['$scope', '$rootScope', '$stateParams', '$mdDialog', 'Project', function($scope, $rootScope, $stateParams, $mdDialog, Project) {

	$scope.project = {};

	$scope.chart = {
		labels: [],
		series: ['Ideal velocity', 'Current velocity'],
		data: [],
		options: {
			responsive: true,											
		}		
	}



	Project.getProjectBySlug($stateParams.projectSlug).then(function(data) {
		$scope.project = data;
		$scope.deadline = moment(data.deadline).calendar();
		$rootScope.pageTitle = data.name;
		
		
		for (var date = moment(data.created_at); date.isBefore(moment(data.deadline).add(1,'day')); date.add(1, 'day')) {
			$scope.chart.labels.push(date.fromNow());
		};

		Project.getProjectVelocity(data.id).then(function(data) {				
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

		Project.getProjectSprintStatus(data.id).then(function(data) {
			$scope.sprints = data;
		});
	});	
}]);