'use strict';

/* App Module */

var NearCoffeeApp = angular.module('NearCoffeeApp', [
  'ngRoute',
  'NearCoffeeAppCtrl',
  'toaster'
]);

NearCoffeeApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/home', {
        templateUrl: 'tmp/home.html',
        controller: 'HomeCtrl'
      }).
      when('/login', {
        templateUrl: 'tmp/login.html',
        controller: 'LoginCtrl'
      }).
      when('/register', {
        templateUrl: 'tmp/register.html',
        controller: 'RegisterCtrl'
      }).
      when('/search', {
        templateUrl: 'tmp/search.html',
        controller: 'SearchCtrl'
      }).
      when('/explore', {
        templateUrl: 'tmp/explore.html',
        controller: 'ExploreCtrl'
      }).
      when('/more/:venId', {
        templateUrl: 'tmp/more.html',
        controller: 'MoreDetailCtrl'
      }).
      when('/app/:key', {
        templateUrl: 'tmp/app_info.html',
        controller: 'AppCtrl'
      }).
      otherwise({
        redirectTo: '/login'
      });
  }])
  .run(function ($rootScope, $location, Data) {
        $rootScope.$on("$routeChangeStart", function (event, next, current) {
            $rootScope.authenticated = false;
            Data.get('session').then(function (results) {
                if (results.uid) {
                    $rootScope.authenticated = true;
                    $rootScope.uid = results.uid;
                    $rootScope.name = results.name;
                    $rootScope.email = results.email;
                } else {
                    var nextUrl = next.$$route.originalPath;
                    if (nextUrl == '/signup' || nextUrl == '/login') {

                    } else {
                        $location.path("/login");
                    }
                }
            });
        });
    });
