(function(){
	var user = function ($scope,$log,$http,NgTableParams,settings,$routeParams){
     // $scope.jj = 'mee';
     $scope.settings = settings;
    
     $scope.view_projects = function(){
       $scope.reposLoaded = false;

        $scope.userLoaded = false;
        $scope.name = "Joyce Kemboi";
        $scope.username = "joycekemboi";
         
        $http.get("https://api.github.com/users/" + $scope.username)
            .success(function (data) {
                $scope.userData = data;
                loadRepos();
            });

        var loadRepos = function () {
            $http.get($scope.userData.repos_url)
                .success(function (data) {
                    $scope.repoData = data;
                });
        };
          

        $scope.predicate = '-updated_at';



     };

     $scope.edit = function(){
     	var id = $routeParams.id;
      
     	// $http({
      //         method:'post',
      //         url:'api/users/edit_user.php',
      //         data:id
      //   	}).success(function(res){
		    //   	$scope.user=res;
      //   		 // $('#instmsg_edit').html(res);

		    //   });
     }
     // edit
 //      $scope.edit_user = function(data){
	// $http({
 //          method:'post',
 //          url:'api/users/edit_user.php',
 //          data:data
 //    	}).success(function(res){
	//       	$scope.response=res;
 //    		 $('#instmsg_edit').html(res);

	//       });

 //      };
  
	};
	user.$inject=['$scope','$log','$http','NgTableParams','settings','$routeParams'];
	angular.module('project').controller('UserController',user);
  
}());