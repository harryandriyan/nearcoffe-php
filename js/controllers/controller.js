var NearCoffeeAppCtrl = angular.module('NearCoffeeAppCtrl', []);

NearCoffeeAppCtrl.controller('HomeCtrl', function ($scope, $rootScope) { 

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


NearCoffeeAppCtrl.controller('MoreDetailCtrl', function ($scope, $http, $routeParams) {
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
		    // this feature is in the GeoJSON format: see geojson.org
		    // for the full specification
		    type: 'Feature',
		    geometry: {
		        type: 'Point',
		        // coordinates here are in longitude, latitude order because
		        // x, y is the standard for GeoJSON and many formats
		        coordinates: [
		          venue.location.lng,
		          venue.location.lat
		        ]
		    },
		    properties: {
		        title: venue.name,
		        description: venue.location.address+', '+venue.location.city+', '+venue.location.country,
		        // one can customize markers by adding simplestyle properties
		        // https://www.mapbox.com/guides/an-open-platform/#simplestyle
		        'marker-size': 'large',
		        'marker-color': '#BE9A6B',
		        'marker-symbol': 'cafe'
		    }
		}).addTo(map);
	}
	$scope.getDetailVenue();
});