sjControllers.controller('IssuesController', ['$scope', '$state', '$rootScope', '$mdDialog', 'Product', '$stateParams',
 function($scope, $state, $rootScope, $mdDialog, Product, $stateParams){

 	$scope.products = {};
 	$scope.issues = {};
 	$scope.currentProduct = {};
 	$scope.issueStages = {};
 	
 	function loadProducts() {
 		Product.getAllProducts().then(function(data) {
 			$scope.products = data;
 			angular.forEach(data, function(prod) {
 				if(prod.id == $stateParams.productId) {
 					Product.getProductById($stateParams.productId).then(function(cp) {
 						console.log(cp);
 						$scope.currentProduct = cp;
 					});
 					$scope.currentProduct = prod;
 				}
 			});
 		});
 	}

 	if($stateParams.productId != null) {
 		Product.getIssueStages().then(function(data) {
	 		$scope.issueStages = data;
	 	});
 	}

 	loadProducts();

 	$scope.productSelected = function(prod) { 		
 		$state.go($state.current, {productId: prod});
 		//, {reload: true}
 	}

 	$scope.creaetProduct = function(ev) {
 		$mdDialog.show({			
			controller: ['$scope','$mdDialog', 'User', function($scope, $mdDialog) {								
				
				$scope.cancel = function() {
					loadProducts();
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {					
					loadProducts();
					$mdDialog.hide(data);
				}

				$scope.makeSlug = function(str) {
					if(str) {
						$scope.product.slug = str.toLowerCase()
											.replace(/[^\w ]+/g,'')
											.replace(/ +/g,'-');
					}
				}; 
			}],
      		templateUrl: 'templates/forms/create_product.html',
      		targetEvent: ev
		}).then(function(data) {
			Product.createProduct(data);
			$state.go($state.current, {productId: $stateParams.productId});			
		});
 	};

 	$scope.createIssue = function(ev) {
 		$mdDialog.show({			
 			locals: {
 				Prods: $scope.products
 			},
			controller: ['$scope','$mdDialog', 'Prods', function($scope, $mdDialog, Prods) {								
				$scope.products = Prods;
				$scope.cancel = function() {
					loadProducts();
					$mdDialog.cancel();					
				}

				$scope.submit = function(data) {					
					loadProducts();
					$mdDialog.hide(data);
				}

				$scope.makeSlug = function(str) {
					if(str) {
						$scope.issue.slug = str.toLowerCase()
											.replace(/[^\w ]+/g,'')
											.replace(/ +/g,'-');
					}
				}; 
			}],
      		templateUrl: 'templates/forms/create_issue.html',
      		targetEvent: ev
		}).then(function(data) {
			Product.createIssue(data);
			loadProducts();
		});
 	};

 	$scope.tranferIssue = function(stageId, issueId) {
 		Product.tranferIssue({
 			stageId: stageId,
 			issueId: issueId
 		}).then(function(data) {
 			$state.go($state.current, {productId: $stateParams.productId}, {reload: true});
 		});
 	}
}]);