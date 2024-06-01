var app = angular.module('FinanceApp', []);

  //users
  app.controller('myCtrl', function($scope, $http) {
    
    // Initialize login and signup data objects
    $scope.loginData = {};
    $scope.signupData = {};
  
    // Function to handle login
    $scope.login = function() {
      // Send login data to login.php for validation
      $http.post('login.php', $scope.loginData)
        .then(function(response) {
          // Handle response from PHP backend
          if (response.data === "success") {
            // Login successful, perform actions such as redirecting to dashboard
            console.log("Login successful");
          } else {
            // Login failed, display error message
            console.log("Login failed. Invalid credentials.");
          }
        }, function(error) {
          // Handle error
          console.log(error);
          // Optionally, display an error message to the user
        });
    };
  
    // Function to handle signup
    $scope.signup = function() {
      // Send signup data to signup.php to create new user
      $http.post('signup.php', $scope.signupData)
        .then(function(response) {
          // Handle response from PHP backend
          if (response.data === "success") {
            // Signup successful, perform actions such as redirecting to dashboard
            console.log("Signup successful");
          } else {
            // Signup failed, display error message
            console.log("Signup failed. Please try again.");
          }
        }, function(error) {
          // Handle error
          console.log(error);
          // Optionally, display an error message to the user
        });
    };
  });
  
  