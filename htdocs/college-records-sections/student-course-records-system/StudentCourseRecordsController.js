	
mainApp.controller('studentCourseRecordsController', function($scope, $http){
	
	$scope.studentCourseInfo = {
		studentID: "",
		courseID: "",
		grade: ""
	};
	
	$scope.result = "";
	$scope.result_table = "";
	$scope.block_input = false;

	$scope.submitData = function(){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';

		var studentCourseInfo = $scope.studentCourseInfo;
		
		var data = {
			command: 0,
			studentID: studentCourseInfo.studentID,
			courseID: studentCourseInfo.courseID,
			grade: studentCourseInfo.grade
		}
		
		//data = $scope.cleanInputs(data);
		
		$http.post("php/student-course-info-access.php",data)
		.success(function(response) {
			$scope.result = response;
			document.getElementById('simple-report').style.display = 'inline';
		});
		
	};
			
	$scope.retrieveData = function(reason){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';
		
		var studentCourseInfo = $scope.studentCourseInfo;
		var data = {
			command: 1,
			studentID: studentCourseInfo.studentID,
			courseID: studentCourseInfo.courseID,
			grade: studentCourseInfo.grade
		}
		
		$http.post("php/student-course-info-access.php",data)
		.success(function(response) {
			if(response.length == 0){
				$scope.result = "No student-course data was retrieved with the given search requirements.";
				document.getElementById('simple-report').style.display = 'inline';
			}	
		
			else{
				$scope.result_table = response;
				
				if(reason == 0){
					$scope.result = "Data Retrieved: ";
					document.getElementById('search-report').style.display = 'inline';
				}
				
				else if (reason == 1){
					$scope.result = "The following entries will be deleted. Would you like to continue? WARNING: Course data will also be deleted from other records!";
					$scope.block_input = true;
					
					document.getElementById('search-report').style.display = 'inline';
				}
			}
		});
	};

	$scope.deleteData = function(){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';
		
		var studentCourseInfo = $scope.studentCourseInfo;
		
		var data = {
			command: 2,
			studentID: studentCourseInfo.studentID,
			courseID: studentCourseInfo.courseID,
			grade: studentCourseInfo.grade
		}
		
		$http.post("php/student-course-info-access.php",data)
		.success(function(response) {
			$scope.result = response;
			$scope.block_input = false;
			document.getElementById('simple-report').style.display = 'inline';
		});
	};

	$scope.updateData = function(){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';

		var studentCourseInfo = $scope.studentCourseInfo;
		
		var data = {
			command: 3,
			studentID: studentCourseInfo.studentID,
			courseID: studentCourseInfo.courseID,
			grade: studentCourseInfo.grade
		}
		
		$http.post("php/student-course-info-access.php",data)
		.success(function(response) {
			$scope.result = response;
			document.getElementById('simple-report').style.display = 'inline';
		});
	};

	$scope.clearInput = function(message){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';
		
		$scope.studentCourseInfo.studentID = "";
		$scope.studentCourseInfo.courseID = "";
		$scope.studentCourseInfo.grade = "";
		
		$scope.result = message;
		$scope.block_input = false;
		
		document.getElementById('simple-report').style.display = 'inline';
	};
		
	$scope.missingInput = function(form){
		return (form.studentID.$invalid || form.studentID.$modelValue.length == 0 ||
			form.courseID.$invalid || form.courseID.$modelValue.length == 0 || 
			form.grade.$invalid || form.grade.$modelValue.length == 0);
	};

	// Basically the same as missingInput except this doesn't check if the input is blank.
	$scope.invalidInputs = function(form){
		return (form.studentID.$invalid ||
			form.courseID.$invalid ||
			form.grade.$invalid);
	};

	$scope.badInput = function(form_input){
		if(form_input){
			return {'visibility' : 'visible'};
		}

		else{
			return {'visibility' : 'hidden'};
		}
	};
		
});