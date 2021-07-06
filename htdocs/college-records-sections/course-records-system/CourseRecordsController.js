	
mainApp.controller('courseRecordsController', function($scope, $http){
	
	$scope.courseInfo = {
		courseID: "",
		courseName: "",
		profID: "",
		courseTime: "",
		courseDays: ""
	};
	
	$scope.result = "";
	$scope.result_table = "";
	$scope.block_input = false;

	$scope.temp = '\d{8}'

	$scope.submitData = function(){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';

		var courseInfo = $scope.courseInfo;
		
		var data = {
			command: 0,
			courseID: courseInfo.courseID,
			courseName: courseInfo.courseName,
			profID: courseInfo.profID,
			courseTime: courseInfo.courseTime,
			courseDays: courseInfo.courseDays,
		}
		
		//data = $scope.cleanInputs(data);
		
		$http.post("php/course-info-access.php",data)
		.success(function(response) {
			$scope.result = response;
			document.getElementById('simple-report').style.display = 'inline';
		});
		
	};
			
	$scope.retrieveData = function(reason){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';
		
		var courseInfo = $scope.courseInfo;
		var data = {
			command: 1,
			courseID: courseInfo.courseID,
			courseName: courseInfo.courseName,
			profID: courseInfo.profID,
			courseTime: courseInfo.courseTime,
			courseDays: courseInfo.courseDays,
			state: courseInfo.state,
			country: courseInfo.country,
			phone: courseInfo.phone,
			email: courseInfo.email	
		}
		
		$http.post("php/course-info-access.php",data)
		.success(function(response) {
			if(response.length == 0){
				$scope.result = "No course data was retrieved with the given search requirements.";
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
		
		var courseInfo = $scope.courseInfo;
		
		var data = {
			command: 2,
			courseID: courseInfo.courseID,
			courseName: courseInfo.courseName,
			profID: courseInfo.profID,
			courseTime: courseInfo.courseTime,
			courseDays: courseInfo.courseDays,
		}
		
		$http.post("php/course-info-access.php",data)
		.success(function(response) {
			$scope.result = response;
			$scope.block_input = false;
			document.getElementById('simple-report').style.display = 'inline';
		});
	};

	$scope.updateData = function(){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';

		var courseInfo = $scope.courseInfo;
		
		var data = {
			command: 3,
			courseID: courseInfo.courseID,
			courseName: courseInfo.courseName,
			profID: courseInfo.profID,
			courseTime: courseInfo.courseTime,
			courseDays: courseInfo.courseDays,
		}
		
		$http.post("php/course-info-access.php",data)
		.success(function(response) {
			$scope.result = response;
			document.getElementById('simple-report').style.display = 'inline';
		});
	};

	$scope.clearInput = function(message){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';
		
		$scope.courseInfo.courseID = "";
		$scope.courseInfo.courseName = "";
		$scope.courseInfo.profID = "";
		$scope.courseInfo.courseTime = "";
		$scope.courseInfo.courseDays = "";
		
		$scope.result = message;
		$scope.block_input = false;
		
		document.getElementById('simple-report').style.display = 'inline';
	};
		
	$scope.missingInput = function(form){
		return (form.courseID.$invalid || form.courseID.$modelValue.length == 0 ||
			form.courseName.$invalid || form.courseName.$modelValue.length == 0 ||
			form.profID.$invalid || form.profID.$modelValue.length == 0 ||
			form.courseTime.$invalid || form.courseTime.$modelValue.length == 0 ||
			form.courseDays.$invalid || form.courseDays.$modelValue.length == 0);
	};

	// Basically the same as missingInput except this doesn't check if the input is blank.
	$scope.invalidInputs = function(form){
		return (form.courseID.$invalid ||
			form.courseName.$invalid || 
			form.profID.$invalid || 
			form.courseTime.$invalid || 
			form.courseDays.$invalid);
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