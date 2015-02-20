sjDirectives.directive('sjProjectsList', [ function(){	
	return {		
		
		scope: {
			user: '='
		}, // {} = isolate, true = child, false/undefined = no change

		controller: ['$scope', 'Project', 'User', function($scope, Project, User) {			
			Project.getProjects($scope.user.id).then(function(data) {				
				$scope.projects = data;	
			});			
		}],		
		restrict: 'E', // E = Element, A = Attribute, C = Class, M = Comment		
		templateUrl: 'directives/projects_list.html',
		replace: true,
		// compile: function(tElement, tAttrs, function transclude(function(scope, cloneLinkingFn){ return function linking(scope, elm, attrs){}})),
		// link: function($scope, iElm, iAttrs, controller) {
			
		// }
	};
}]);