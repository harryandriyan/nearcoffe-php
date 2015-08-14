'use strict';

/* App Module */

var NearCoffeeApp = angular.module('NearCoffeeApp', [
  'ngRoute',
  'NearCoffeeAppCtrl',
]);

NearCoffeeApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/home', {
        templateUrl: 'tmp/home.html',
        controller: 'HomeCtrl'
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
        redirectTo: '/home'
      });
  }]);