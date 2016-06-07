myApp.factory('Authentication', ['$rootScope', '$firebaseAuth', '$firebaseObject', '$location', 'FIREBASE_URL', function($rootScope, $firebaseAuth, $firebaseObject, $location, FIREBASE_URL){

	var ref = new Firebase(FIREBASE_URL);
	var auth = $firebaseAuth(ref);

	auth.$onAuth(function(authUser) {

		if(authUser){
			var userRef = new Firebase(FIREBASE_URL + 'users/' + authUser.uid);
			var userObj = $firebaseObject(userRef);
			$rootScope.currentUser = userObj;

		} else {
			$rootScope.currentUser = '';
		}
	});

	// putting methods into an object
	var myObj =  {
		login: function(user) {
			auth.$authWithPassword({
				email: user.email,
				password: user.password
			}).then(function(regUser){
				$location.path('/success');
			}).catch(function(error){
				$rootScope.message = error.message; 
			});
		}, // login

		logout: function(){
			return auth.$unauth();
		}, // logout

		requireAuth: function(){
			return auth.$requireAuth();
		}, // requireAuth

		register: function(user) {
			auth.$createUser({
				email: user.email,
				password: user.password
			}).then(function(regUser){

				var regRef = new Firebase(FIREBASE_URL + 'users')
				.child(regUser.uid).set({
					date: Firebase.ServerValue.TIMESTAMP,
					regUser: regUser.uid,
					firstname: user.firstname,
					lastname: user.lastname,
					email: user.email
				});

				// Logs user in if registration was successfull. Passes over user info.
				myObj.login(user);

			}).catch(function(error){
				$rootScope.message = error.message; 
			}); // createuser
		}, //

		fbRegister: function(){
			
			ref.authWithOAuthPopup("facebook", function(error, authData) {

			  if (error) {
			    console.log("Login Failed!", error);
			  } else {
			    console.log("Authenticated successfully with payload:", authData);
			    
			    var firstname = authData.facebook.cachedUserProfile.first_name;
			    var lastname = authData.facebook.cachedUserProfile.last_name;
			    var email = authData.facebook.email;
			    var id = authData.uid;
			    
				var regRef = new Firebase(FIREBASE_URL + 'users')
				.child(id).set({
					date: Firebase.ServerValue.TIMESTAMP,
					regUser: id,
					firstname: firstname,
					lastname: lastname,
					email: email
				});



				$location.path('/success');
				
			  }
			}, {scope: 'email'});
		}, //facebook

		googleRegister: function(){
			
			ref.authWithOAuthPopup("google", function(error, authData) {
			  if (error) {
			    console.log("Login Failed!", error);
			  } else {
			    console.log("Authenticated successfully with payload:", authData);
			    var email = authData.google.email;
			    var lastname = authData.google.cachedUserProfile.family_name;
			    var firstname = authData.google.cachedUserProfile.given_name;
			    var id = authData.uid;

				var regRef = new Firebase(FIREBASE_URL + 'users')
				.child(id).set({
					date: Firebase.ServerValue.TIMESTAMP,
					regUser: id,
					firstname: firstname,
					lastname: lastname,
					email: email
				});

			    $location.path('/success');
			  }
			}, {scope: 'email'});
		} // google
	}
	
	return myObj;
}]); // factory end
