var myApp = angular.module('myApp',
  ['ngRoute', 'firebase'])
  .constant('FIREBASE_URL', 'https://appregistration5577.firebaseio.com/');

// checks if there is an error with the authentication
  myApp.run(['$rootScope', '$location', function($rootScope, $location){
  	$rootScope.$on('$routeChangeError', function(event, next, previous, error){
  		// check if authentication is required
  		if(error=='AUTH_REQUIRED'){
  			// display message and redirect to login page
  			$rootScope.message = 'Xin lỗi ban cần đăng nhập để trúy xuất vào trang !!!';
  			$location.path('/login');
  		} // end if
  	}); // event info
  }]); // run


myApp.config(['$routeProvider', function($routeProvider){
	$routeProvider.
		when('/login', {
			templateUrl: 'views/login.html',
			controller: 'RegistrationController'
		}).
		when('/register',{
			templateUrl: 'views/register.html',
			controller: 'RegistrationController'
		}).
		when('/success', {
			templateUrl: 'views/success.html',
			controller: 'SuccessController',
			resolve: {
				currentAuth: function(Authentication){
					return Authentication.requireAuth();
				} // currentAuth
			} // resolve
		}).
		otherwise({
			redirectTo: '/login'
		})
}]);