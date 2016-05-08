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

//save venue
$app->post('/savevenue', function() use ($app) {
    session_start();
    $response = array();
    $r = json_decode($app->request->getBody());

    $r->foursquare_id = $venId = $r->venId;
    $r->name = $venName = $r->venName;
    $r->user_id = $user_id = $_SESSION['nc_uid'];
    $table_name = "venue";
    
    $near_db = new near_query_handler();

    $isVenueSaved = $near_db->getOneRecord("select 1 from ".$table_name." where foursquare_id='".$venId."' and user_id='".$user_id."'");
    
    if(!$isVenueSaved) {

        $column_names = array('foursquare_id','name', 'user_id');
        $result = $near_db->insertIntoTable($r, $column_names, $table_name);

        if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "Venue Saved";
            echoResponse(200, $response);
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to save Venue. Please try again";
            echoResponse(201, $response);
        }
    }
    else {
        $response["status"] = "info";
        $response["message"] = "The Venue already saved";
        echoResponse(201, $response);
    }
});

//delete venue
$app->post('/deletevenue', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());

    $id = $r->id;
    $table_name = "venue";
    
    $near_db = new near_query_handler();
    $do_delete = $near_db->deleteRecord("delete from ".$table_name." where id='".$id."'");
    if ($do_delete) {
        $response["status"] = "info";
        $response["message"] = "The Venue was deleted";
        echoResponse(201, $response);
    }
});

//add comment
$app->post('/addcomment', function() use ($app) {
    session_start();
    $response = array();
    $r = json_decode($app->request->getBody());

    $r->user_id = $user_id = $_SESSION['nc_uid'];
    $r->venue_id = $venue_id = $r->venue_id;
    $r->comment_data = $comment = $r->comment;
    $table_name = "comment";
    
    $near_db = new near_query_handler();

    $column_names = array('user_id','venue_id','comment_data');
    $result = $near_db->insertIntoTable($r, $column_names, $table_name);

    if ($result != NULL) {
        $response["status"] = "success";
        $response["message"] = "Comment added successfully";
        echoResponse(200, $response);
    } else {
        $response["status"] = "error";
        $response["message"] = "Failed to add comment";
        echoResponse(201, $response);
    }
});

// GET Comments
$app->get(
    '/getcomments/:id',
    function ($id) use ($app) {
      $near_db = new near_query_handler();
      $comments = $near_db->getComments($id);
      
      $app->response()->header("Content-Type", "application/json");
      $response["venue"] = $id;
      $response["comments"] = $comments;
      echoResponse(200, $response);
    }
);