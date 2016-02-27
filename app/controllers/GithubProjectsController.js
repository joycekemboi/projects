function(){
	var projects = function ($scope,$log,$http,NgTableParams,settings,$routeParams){
		$scope.username = "joycekemboi";
        $http.get("https://api.github.com/users/"+$scope.username)
        .success(function(data) {
            $scope.userData = data;
        });

	projects.$inject=['$scope','$log','$http','NgTableParams','settings','$routeParams'];
	angular.module('project').controller('GithubProjectsController',projects);

}());