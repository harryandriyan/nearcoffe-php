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
      when('/logout', {
        templateUrl: 'tmp/logout.html',
        controller: 'LogoutCtrl'
      }).
      when('/register', {
        templateUrl: 'tmp/register.html',
        controller: 'RegisterCtrl'
      }).
      when('/profile', {
        templateUrl: 'tmp/profile.html',
        controller: 'ProfileCtrl'
      }).
      when('/myvenues', {
        templateUrl: 'tmp/myvenues.html',
        controller: 'MyvenuesCtrl'
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
                if (results.nc_uid) {
                    $rootScope.authenticated = true;
                    $rootScope.nc_uid = results.nc_uid;
                    $rootScope.nc_name = results.nc_name;
                    $rootScope.nc_email = results.nc_email;
                } else {
                    var nextUrl = next.$$route.originalPath;
                    if (nextUrl == '/register' || nextUrl == '/login') {

                    } else {
                        $location.path("/login");
                    }
                }
            });
        });
    });
