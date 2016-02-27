(function(){
	var user = function ($scope,$log,$http,NgTableParams,settings,$routeParams){
     // $scope.jj = 'mee';
     $scope.settings = settings;
     $scope.get_users = function(){
     	$http({
         method:'post',
         url:'api/users/view.php'
     	}).success(function(rs){
         $scope.users = new NgTableParams({},{filterDelay:0,dataset:rs});

     	});
     };
     $scope.showMe = function(data){
        $scope.show=true;
        $scope.hide=true;
	        	//alert('joyc');
        	$http({
              method:'post',
              url:'api/users/edit_user.php',
              data:data
        	}).success(function(res){
		      	$scope.response=res;
        		 $('#instmsg_edit').html(res);

		      });
	        
    
     }
     // addition
     // function to submit the form after all validation has occurred            
     $scope.submitForm = function(isValid)
     {
     	// check to make sure the form is completely valid
	    if (isValid) {
	      // alert('our form is amazing');
	        $scope.create_user = function(data){
	        	//alert('joyc');
	        	$http({
                  method:'post',
                  url:'api/users/add_new.php',
                  data:data
	        	}).success(function(res){
			      	$scope.response=res;
	        		 $('#instmsg').html(res);

			      });
	        };
	    }
     };
    
     $scope.edit = function(){
     	var id = $routeParams.id;
     	$http({
              method:'post',
              url:'api/users/edit_user.php',
              data:id
        	}).success(function(res){
		      	$scope.user=res;
        		 // $('#instmsg_edit').html(res);

		      });
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