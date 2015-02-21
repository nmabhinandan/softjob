sjControllers.controller('ProjectListController', ['$scope', '$rootScope', '$mdDialog', '$mdToast', 'Project', 
	function($scope, $rootScope, $mdDialog, $mdToast, Project){
	$rootScope.pageTitle = 'Projects';
	$scope.chart = {
		labels: [],
		data: [],
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
	});	

	$scope.createProject = function(ev) {
		$mdDialog.show({			
			controller: ['$scope','$mdDialog','$rootScope', function($scope,$mdDialog,$rootScope) {				
				$scope.cancel = function() {					
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {
					data.owner_type = 'user';
					data.owner_id = $rootScope.loggedInUser.id;
					data.organization_id = $rootScope.loggedInUser.organization_id;
					data.project_manager_id = $rootScope.loggedInUser.id;
					console.log(data);
					$mdDialog.hide(data);
				}

				$scope.makeSlug = function(str) {
					$scope.project.slug = str.toLowerCase()
											.replace(/[^\w ]+/g,'')
											.replace(/ +/g,'-');
				}; 
			}],
      		templateUrl: 'templates/forms/create_project.html',
      		targetEvent: ev,
		}).then(function(data) {
			Project.createProject(data);
			$mdToast.show($mdToast.simple().content("New project is created"));		
		});
	};
}]);