var mainApp = angular.module("mainApp", ['ngRoute']);

mainApp.config(['$routeProvider', function($routeProvider) {
	$routeProvider
		.when('/student-records', {
			templateUrl: 'student-records.htm',
			controller: 'studentRecordsController'
		})
			
		.when('/course-records', {
			templateUrl: 'course-records.htm',
			controller: 'courseRecordsController'
		})

		.when('/professor-records', {
			templateUrl: 'prof-records.htm',
			controller: 'profRecordsController'
		})
		
		.when('/student-course-records', {
			templateUrl: 'student-course-records.htm',
			controller: 'studentCourseRecordsController'
		})
		
		.when('/grade-records', {
			templateUrl: 'grade-records.htm',
			controller: 'gradeRecordsController'
		})

		.otherwise({
			redirectTo: '/'
		});
}]);