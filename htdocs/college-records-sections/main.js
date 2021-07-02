var mainApp = angular.module("mainApp", ['ngRoute']);

mainApp.config(['$routeProvider', function($routeProvider) {
	$routeProvider
		.when('/student-records', {
			templateUrl: 'student-records.htm',
			controller: 'studentRecordsController'
		})
					
		.otherwise({
			redirectTo: '/'
		});
}]);