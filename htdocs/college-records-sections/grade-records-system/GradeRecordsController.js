mainApp.controller('gradeRecordsController', function($scope, $http){
	
	$scope.gradeInfo = {
		studentID: "",
		currentGPA: "",
		totalGPA: "",
		semCredits: "",
		totalCredits: "",
		canGrad: ""
	};
	
	$scope.result = "";
	$scope.result_table = "";
	$scope.block_input = false;

	$scope.submitData = function(){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';

		var gradeInfo = $scope.gradeInfo;
		
		var data = {
			command: 0,
			studentID: gradeInfo.studentID,
			currentGPA: gradeInfo.currentGPA,
			totalGPA: gradeInfo.totalGPA,
			semCredits: gradeInfo.semCredits,
			totalCredits: gradeInfo.totalCredits,
			canGrad: gradeInfo.canGrad,
		}
		
		//data = $scope.cleanInputs(data);
		
		$http.post("php/grade-info-access.php",data)
		.success(function(response) {
			$scope.result = response;
			document.getElementById('simple-report').style.display = 'inline';
		});
		
	};
			
	$scope.retrieveData = function(reason){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';
		
		var gradeInfo = $scope.gradeInfo;
		var data = {
			command: 1,
			studentID: gradeInfo.studentID,
			currentGPA: gradeInfo.currentGPA,
			totalGPA: gradeInfo.totalGPA,
			semCredits: gradeInfo.semCredits,
			totalCredits: gradeInfo.totalCredits,
			canGrad: gradeInfo.canGrad,
		}
		
		$http.post("php/grade-info-access.php",data)
		.success(function(response) {
			if(response.length == 0){
				$scope.result = "No course data was retrieved with the given search requirements.";
				document.getElementById('simple-report').style.display = 'inline';
			}	
		
			else{
				$scope.result_table = response
				
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
		
		var gradeInfo = $scope.gradeInfo;
		
		var data = {
			command: 2,
			studentID: gradeInfo.studentID,
			currentGPA: gradeInfo.currentGPA,
			totalGPA: gradeInfo.totalGPA,
			semCredits: gradeInfo.semCredits,
			totalCredits: gradeInfo.totalCredits,
			canGrad: gradeInfo.canGrad,
		}
		
		$http.post("php/grade-info-access.php",data)
		.success(function(response) {
			$scope.result = response;
			$scope.block_input = false;
			document.getElementById('simple-report').style.display = 'inline';
		});
	};

	$scope.updateData = function(){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';

		var gradeInfo = $scope.gradeInfo;
		
		var data = {
			command: 3,
			studentID: gradeInfo.studentID,
			currentGPA: gradeInfo.currentGPA,
			totalGPA: gradeInfo.totalGPA,
			semCredits: gradeInfo.semCredits,
			totalCredits: gradeInfo.totalCredits,
			canGrad: gradeInfo.canGrad,
		}
		
		$http.post("php/grade-info-access.php",data)
		.success(function(response) {
			$scope.result = response;
			document.getElementById('simple-report').style.display = 'inline';
		});
	};

	$scope.clearInput = function(message){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';
		
		$scope.gradeInfo.studentID = "";
		$scope.gradeInfo.currentGPA = "";
		$scope.gradeInfo.totalGPA = "";
		$scope.gradeInfo.semCredits = "";
		$scope.gradeInfo.totalCredits = "";
		$scope.gradeInfo.canGrad = "";
		
		$scope.result = message;
		$scope.block_input = false;
		
		document.getElementById('simple-report').style.display = 'inline';
	};
	
	$scope.missingInput = function(form){
		return (form.studentID.$invalid || form.studentID.$modelValue.length == 0 ||
			form.currentGPA.$invalid || form.currentGPA.$modelValue.length == 0 ||
			form.totalGPA.$invalid || form.totalGPA.$modelValue.length == 0 ||
			form.semCredits.$invalid || form.semCredits.$modelValue.length == 0 ||
			form.totalCredits.$invalid || form.totalCredits.$modelValue.length == 0 ||
			form.canGrad.$invalid || form.canGrad.$modelValue.length == 0);
	};

	// Basically the same as missingInput except this doesn't check if the input is blank.
	$scope.invalidInputs = function(form){
		return (form.studentID.$invalid ||
			form.currentGPA.$invalid ||
			form.totalGPA.$invalid ||		
			form.semCredits.$invalid || 
			form.totalCredits.$invalid || 
			form.canGrad.$invalid);
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