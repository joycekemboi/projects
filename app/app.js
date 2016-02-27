(function(){
 var project = angular.module("project",['ngRoute','ngTable','ngAnimate']);
 project.config(function($routeProvider){
 	$routeProvider
 		
 			.when('/',{
 				controller:'UserController',
 				templateUrl:'app/views/users/view.html'
 			})
 			// .when('/users/add_new',{
 			// 	controller:'UserController',
 			// 	templateUrl:'app/views/users/add_new.html'
 			// })
 			// .when('/users/edit/:id',{
 			// 	controller:'UserController',
 			// 	templateUrl:'app/views/users/edit.html'
 			// })
 			.otherwise({redirectTo:'/'})
 });
}());