sjDirectives.directive('sjTag', [function(){
	// Runs during compile
	return {
		scope: {
			input: '=',			
			tags: '='
			// placeholder: '@',
			// project: '=',
			// task: '=',
		}, // {} = isolate, true = child, false/undefined = no change
		// require: 'ngModel',

		controller: ['$scope', 'Project', 'User', 'Tag', function($scope, Project, User, Tag) {
		// 	var projectServerTags = [];
		// 	var taskServerTags = [];	
		// 	$scope.finalTags = [];
		// 	if($scope.project !== undefined) {
		// 		Tag.getAllProjectTags().then(function(data) {
		// 			projectServerTags = data;					
		// 		});
		// 	}
			
		// 	$scope.tagSubmitted = function(val) {
		// 		// console.log(val);
		// 		$scope.finalTags.push(val);
		// 	};

		// 	$scope.tagChanged = function(val) {
		// 		var tagString = val.trim();
		// 		var newTag = '';
		// 		if(tagString.slice(-1) == ",") {
		// 			for(var i=tagString.length-1;i>=0;i--) {						
		// 				console.log(tagString[i]);
		// 				newTag += tagString[i];
		// 				if(tagString[i] == ",") {
		// 					break;
		// 				}
		// 			}
		// 			$scope.tagSubmitted(newTag);
		// 		}
		// 	};			
		}],		
		restrict: 'E', // E = Element, A = Attribute, C = Class, M = Comment		
		templateUrl: 'directives/tags.html',
		replace: true,
		// compile: function(tElement, tAttrs, function transclude(function(scope, cloneLinkingFn){ return function linking(scope, elm, attrs){}})),
		// link: function($scope, iElm, iAttrs, ngModel) {			
			// $scope.$watch('tags', function(val) {
			// 	ngModel.$setViewValue(val);				
			// });			
		// }
	};
}]);