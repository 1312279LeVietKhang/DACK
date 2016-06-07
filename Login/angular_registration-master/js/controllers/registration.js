myApp.controller('RegistrationController', ['$scope', 'Authentication', function($scope, Authentication){
	
	$scope.login = function(){
		Authentication.login($scope.user);
	} // login

	$scope.register = function(){
		Authentication.register($scope.user);
	} //register

	$scope.logout = function(){
		Authentication.logout();
	} // logout

	$scope.fbRegister = function(){
		Authentication.fbRegister();
	}

	$scope.googleRegister = function(){
		Authentication.googleRegister();
	}
		

}]); // controller