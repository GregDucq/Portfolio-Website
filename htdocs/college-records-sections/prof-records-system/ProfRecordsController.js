	
mainApp.controller('profRecordsController', function($scope, $http){
	
	$scope.profInfo = {
		profID: "",
		profName: ""
	};
	
	$scope.result = "";
	$scope.result_table = "";
	$scope.block_input = false;

	$scope.submitData = function(){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';

		var profInfo = $scope.profInfo;
		
		var data = {
			command: 0,
			profID: profInfo.profID,
			profName: profInfo.profName,
		}
		
		//data = $scope.cleanInputs(data);
		
		$http.post("php/prof-info-access.php",data)
		.success(function(response) {
			$scope.result = response;
			document.getElementById('simple-report').style.display = 'inline';
		});
		
	};
			
	$scope.retrieveData = function(reason){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';
		
		var profInfo = $scope.profInfo;
		var data = {
			command: 1,
			profID: profInfo.profID,
			profName: profInfo.profName,
		}
		
		$http.post("php/prof-info-access.php",data)
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
		
		var profInfo = $scope.profInfo;
		
		var data = {
			command: 2,
			profID: profInfo.profID,
			profName: profInfo.profName,
		}
		
		$http.post("php/prof-info-access.php",data)
		.success(function(response) {
			$scope.result = response;
			$scope.block_input = false;
			document.getElementById('simple-report').style.display = 'inline';
		});
	};

	$scope.updateData = function(){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';

		var profInfo = $scope.profInfo;
		
		var data = {
			command: 3,
			profID: profInfo.profID,
			profName: profInfo.profName,
		}
		
		$http.post("php/prof-info-access.php",data)
		.success(function(response) {
			$scope.result = response;
			document.getElementById('simple-report').style.display = 'inline';
		});
	};

	$scope.clearInput = function(message){
		document.getElementById('simple-report').style.display = 'none';
		document.getElementById('search-report').style.display = 'none';
		
		$scope.profInfo.profID = "";
		$scope.profInfo.profName = "";
		
		$scope.result = message;
		$scope.block_input = false;
		
		document.getElementById('simple-report').style.display = 'inline';
	};
		
	$scope.missingInput = function(form){
		return (form.profID.$invalid || form.profID.$modelValue.length == 0 ||
			form.profName.$invalid || form.profName.$modelValue.length == 0);
	};

	// Basically the same as missingInput except this doesn't check if the input is blank.
	$scope.invalidInputs = function(form){
		return (form.profID.$invalid ||
			form.profName.$invalid);
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