var NearCoffeeAppCtrl = angular.module('NearCoffeeAppCtrl', []);

NearCoffeeAppCtrl.controller('HomeCtrl', function ($scope, $rootScope) { 

});

NearCoffeeAppCtrl.controller('ProfileCtrl', function ($scope, $http, Data) { 
	$scope.getProfile = function(){
			$http.get(
				'server/profile'
			).success(function(response){
				$scope.profile = response;
		});
	}
	$scope.getVenues = function(){
		$http.get(
			'server/getvenuesbyuser'
		).success(function(response){
			$scope.venues = response;
		});
	}
	$scope.deletevenue = function (venId) {
        Data.post('deletevenue', {
            id: venId
        }).then(function (results) {
            Data.toast(results);
            $scope.getVenues();
        });
	}
	$scope.getProfile();
	$scope.getVenues();
});

NearCoffeeAppCtrl.controller('LoginCtrl', function ($scope, $rootScope, $location, $http, Data) { 
	$scope.login = {};
    $scope.doLogin = function (customer) {
        Data.post('login', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('home');
            }
        });
    };
});

NearCoffeeAppCtrl.controller('RegisterCtrl', function ($scope, $rootScope, $location, $http, Data) { 
	$rootScope.nc_uid = undefined;
	$scope.register = {email:'',password:'',name:''};
    $scope.doregister = function (customer) {
        Data.post('register', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('home');
            }
        });
    };
});

NearCoffeeAppCtrl.controller('LogoutCtrl', function ($scope, $rootScope, $location, $http, Data) { 
	$scope.logout = function () {
        Data.get('logout').then(function (results) {
            Data.toast(results);
            $location.path('login');
        });
    }
    $rootScope.nc_uid = undefined;
    $scope.logout();
});

NearCoffeeAppCtrl.controller('SearchCtrl', function ($scope, $http) {
	$scope.getVenues = function(lat,lng){
		$scope.loading = "loading";
		$scope.query = 'coffee '+$scope.looking_for;
		$http.get(
			'server/venues/search/'+$scope.query+'/'+lat+'/'+lng+''
		).success(function(response){
			$scope.venues = response.response.venues;
			$scope.loading = undefined;
		});
	}
	$scope.getUserLocationFunc = function(location) {
	    $scope.lat = location.coords.latitude;
	    $scope.lng = location.coords.longitude;
	    $scope.getVenues($scope.lat,$scope.lng)
	}
	$scope.getUserLocation = function () {
		navigator.geolocation.getCurrentPosition($scope.getUserLocationFunc);
	}
});

NearCoffeeAppCtrl.controller('ExploreCtrl', function ($scope, $http) {
	$scope.getVenues = function(lat,lng){
		$scope.loading = "loading";
		$http.get(
			'server/venues/explore/coffee/'+lat+'/'+lng+''
		).success(function(response){
			$scope.location = response.response.headerFullLocation;
			$scope.venues = response.response.groups;
			$scope.loading = undefined;
		});
	}
	$scope.getUserLocation = function(location) {
	    $scope.lat = location.coords.latitude;
	    $scope.lng = location.coords.longitude;
		$scope.getVenues($scope.lat,$scope.lng);
	}
	navigator.geolocation.getCurrentPosition($scope.getUserLocation);
});


NearCoffeeAppCtrl.controller('MoreDetailCtrl', function ($scope,$routeParams, $rootScope, $location, $http, Data) {
	$scope.getDetailVenue = function(){
			$http.get(
				'server/venue/'+$routeParams.venId+''
			).success(function(response){
				$scope.venue = response.response.venue;
				$scope.loadMap($scope.venue);
		});
	}
	$scope.loadMap = function (venue) {
		L.mapbox.accessToken = 'pk.eyJ1IjoiaGFycnlhbmRyaXlhbiIsImEiOiJwbGwyUjlRIn0.AcL2qL6fWTzaXNJNSFRu0g';
		var map = L.mapbox.map('map', 'mapbox.streets')
		    .setView([venue.location.lat, venue.location.lng], 16);
		L.mapbox.featureLayer({
		    type: 'Feature',
		    geometry: {
		        type: 'Point',
		        coordinates: [
		          venue.location.lng,
		          venue.location.lat
		        ]
		    },
		    properties: {
		        title: venue.name,
		        description: venue.location.address+', '+venue.location.city+', '+venue.location.country,
		        'marker-size': 'large',
		        'marker-color': '#BE9A6B',
		        'marker-symbol': 'cafe'
		    }
		}).addTo(map);
	}
    $scope.savevenue = function (venId, venName) {
        Data.post('savevenue', {
            venId: venId,
            venName: venName
        }).then(function (results) {
            Data.toast(results);
        });
	}
	$scope.addComment = function (comment,venue_id) {
		Data.post('addcomment', {
            comment: comment,
            venue_id: venue_id
        }).then(function (results) {
            Data.toast(results);
            comment = '';
        });
	}
	$scope.getComments = function(){
			$http.get(
				'server/getcomments/'+$routeParams.venId+''
			).success(function(response){
				$scope.comments = response.comments;
		});
	}
	$scope.getComments();
	$scope.getDetailVenue();
});