(function(){
 var project = angular.module("project",['ngRoute','ngTable','ngAnimate']);
 project.config(function($routeProvider){
 	$routeProvider
 		
 			.when('/',{
 				controller:'UserController',
 				templateUrl:'app/views/users/view_projects.html'
 			})
 			.when('/users/view_issues/:id',{
 				controller:'UserController',
 				templateUrl:'app/views/users/view_issues.html'
 			})
 			.otherwise({redirectTo:'/'})
 });
}());
