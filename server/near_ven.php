<?php 

/**
 * Foursquare API Request Handler
 */

// GET Venues
$app->get(
    '/venues/:type/:q/:lat/:lng',
    function ($type,$q,$lat,$lng) use ($app) {
      global $near_config;
      require_once("Slim/Helper/FoursquareApi.php");
      // Set your client key and secret
      $client_key = $near_config['client_key'];
      $client_secret = $near_config['client_secret'];

      $foursquare = new FoursquareApi($client_key,$client_secret);
      
      // Prepare parameters
      $params = array("ll"=>"$lat,$lng","query"=>"$q");
      
      // Perform a request to a public resource
      $response = $foursquare->GetPublic("venues/".$type,$params);
      $app->response()->header("Content-Type", "application/json");
      echo $response;
    }
);

// GET Venue Detail
$app->get(
    '/venue/:id',
    function ($id) use ($app) {
      global $near_config;
      require_once("Slim/Helper/FoursquareApi.php");
      // Set your client key and secret
      $client_key = $near_config['client_key'];
      $client_secret = $near_config['client_secret'];

      $foursquare = new FoursquareApi($client_key,$client_secret);
      
      // Perform a request to a public resource
      $response = $foursquare->GetPublic("venues/".$id);
      $app->response()->header("Content-Type", "application/json");
      echo $response;
    }
);