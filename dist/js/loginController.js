var app=angular.module('app',[]);
app.controller('ctrLog',function($scope,$http){
	$scope.send=function(){
		var form=document.querySelector('#form');
		form.submit();
	}

	$scope.ona=function(){
		$http({
			'url':'https://api.ona.io/api/v1/data/301129',
			'method':'GET',
			'dataType': 'json',
			'xhrFields': {
				'withCredentials': false
			},
			'headers':{
				'Authorization':'Basic aGxhbWE6MjZtYWkxOTkx'
			}
		}).then(function(response){
			console.log('Success :',response);
		},function(error){
			console.log('Error :',error);
		})
	}
})