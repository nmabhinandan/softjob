/** jshint ignore: start */
var softjob = angular.module('softjob', [
	'ngMaterial',
	'angular-loading-bar',
	'ngAnimate',
	'ui.router',
	'chart.js',
	'ngDraggable',
	'sjServices',
	'sjControllers',
	'sjDirectives'
]);

var sjServices = angular.module('sjServices', []);
var sjDirectives = angular.module('sjDirectives', []);
var sjControllers = angular.module('sjControllers', []);