	
mainApp.controller('studentRecordsController', function($scope, $http){

	$scope.studentInfo = {
		studentID: "",
		firstName: "",
		lastName: "",
		address: "",
		city: "",
		state: "",
		country: "",
		phone: "",
		email: ""						
	};
						
	$scope.result = "";
	$scope.result_table = "";
	$scope.block_input = false;

	$scope.submitData = function(){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';

		var studentInfo = $scope.studentInfo;

		var data = {
			command: 0,
			studentID: studentInfo.studentID,
			firstName: studentInfo.firstName,
			lastName: studentInfo.lastName,
			address: studentInfo.address,
			city: studentInfo.city,
			state: studentInfo.state,
			country: studentInfo.country,
			phone: studentInfo.phone,
			email: studentInfo.email	
		}
		
		$http.post("php/student-info-access.php",data).success(function(response) {
			$scope.result = response;
			document.getElementById('simple-report').style.display = 'inline';
		});

	};

	$scope.retrieveData = function(reason){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';

		var studentInfo = $scope.studentInfo;
		var data = {
			command: 1,
			studentID: studentInfo.studentID,
			firstName: studentInfo.firstName,
			lastName: studentInfo.lastName,
			address: studentInfo.address,
			city: studentInfo.city,
			state: studentInfo.state,
			country: studentInfo.country,
			phone: studentInfo.phone,
			email: studentInfo.email	
		}

		$http.post("php/student-info-access.php",data).success(function(response) {
			if(response.length == 0){
				$scope.result = "No student data was retrieved with the given search requirements.";
				document.getElementById('simple-report').style.display = 'inline';
			}	

			else{
				$scope.result_table = response;

				if(reason == 0){
					$scope.result = "Data Retrieved: ";
					document.getElementById('search-report').style.display = 'inline';
				}

				else if (reason == 1){
					$scope.result = "The following entries will be deleted. Would you like to continue? WARNING: Student data will also be deleted from other records!";
					$scope.block_input = true;

					document.getElementById('search-report').style.display = 'inline';
				}
			}
		});
	};

	$scope.deleteData = function(){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';

		var studentInfo = $scope.studentInfo;

		var data = {
			command: 2,
			studentID: studentInfo.studentID,
			firstName: studentInfo.firstName,
			lastName: studentInfo.lastName,
			address: studentInfo.address,
			city: studentInfo.city,
			state: studentInfo.state,
			country: studentInfo.country,
			phone: studentInfo.phone,
			email: studentInfo.email
		}

		$http.post("php/student-info-access.php",data).success(function(response) {
			$scope.result = response;
			$scope.block_input = false;
			document.getElementById('simple-report').style.display = 'inline';
		});
	};

	$scope.updateData = function(){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';

		var studentInfo = $scope.studentInfo;

		var data = {
			command: 3,
			studentID: studentInfo.studentID,
			firstName: studentInfo.firstName,
			lastName: studentInfo.lastName,
			address: studentInfo.address,
			city: studentInfo.city,
			state: studentInfo.state,
			country: studentInfo.country,
			phone: studentInfo.phone,
			email: studentInfo.email	
		}

		$http.post("php/student-info-access.php",data).success(function(response) {
			$scope.result = response;
			document.getElementById('simple-report').style.display = 'inline';
		});
	};

	$scope.clearInput = function(message){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';

		$scope.studentInfo.studentID = "";
		$scope.studentInfo.firstName = "";
		$scope.studentInfo.lastName = "";
		$scope.studentInfo.address = "";
		$scope.studentInfo.city = "";
		$scope.studentInfo.state = "";
		$scope.studentInfo.country = "";
		$scope.studentInfo.phone = "";
		$scope.studentInfo.email = "";

		$scope.result = message;
		$scope.block_input = false;

		document.getElementById('simple-report').style.display = 'inline';
	};

	$scope.missingInput = function(form){
		return (form.studentID.$invalid || form.studentID.$modelValue.length == 0 ||
			form.firstName.$invalid || form.firstName.$modelValue.length == 0 ||
			form.lastName.$invalid || form.lastName.$modelValue.length == 0 ||
			form.address.$invalid || form.address.$modelValue.length == 0 ||
			form.city.$invalid || form.city.$modelValue.length == 0 ||
			form.state.$invalid || form.state.$modelValue.length == 0 ||
			form.country.$invalid || form.country.$modelValue.length == 0 ||
			form.phone.$invalid || form.phone.$modelValue.length == 0 ||
			form.email.$invalid || form.email.$modelValue.length == 0);
	};

	// Basically the same as missingInput except this doesn't check if the input is blank.
	$scope.invalidInputs = function(form){
		return (form.studentID.$invalid ||
			form.firstName.$invalid || 
			form.lastName.$invalid || 
			form.address.$invalid || 
			form.city.$invalid || 
			form.state.$invalid || 
			form.country.$invalid || 
			form.phone.$invalid || 
			form.email.$invalid);
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