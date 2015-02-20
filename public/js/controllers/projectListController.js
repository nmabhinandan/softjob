sjControllers.controller('ProjectListController', ['$scope', '$rootScope', 'Project', function($scope, $rootScope, Project){
	$rootScope.pageTitle = 'Projects';
	$scope.chart = {
		labels: [],//['2006', '2007', '2008', '2009', '2010', '2011', '2012'],
		data: [		
			// [65, 59, 80, 81, 56, 55, 40]    
		],
		options: {
			responsive: true,
			barShowStroke : false,
			scaleShowVerticalLines: false,
			barValueSpacing: 20,
		}
	}


	Project.getProjectsStatus($rootScope.loggedInUser.id).then(function(data) {				
		var statuses = [];
		angular.forEach(data,function(value) {			
			$scope.chart.labels.push(value.name.substring(0, 12).toUpperCase()+'...');
			statuses.push(value.status);
		});		
		$scope.chart.data.push(statuses);
		console.log($scope.chart.labels);
		console.log($scope.chart.data);
	});	

}])