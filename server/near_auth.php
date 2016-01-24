<?php 
$app->get('/session', function() {
    $n_session = new near_session();
    $session = $n_session->getSession();
    $response["nc_uid"] = $session['nc_uid'];
    $response["nc_email"] = $session['nc_email'];
    $response["nc_name"] = $session['nc_name'];
    echoResponse(200, $session);
});

$app->post('/login', function() use ($app) {

    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();

    $password = $r->customer->password;
    $email = $r->customer->email;

    $db = new PDO("sqlite:db/neardb.sqlite");
    $sql = $db->prepare("SELECT * FROM user WHERE email='".$email."'");
    $sql->execute(); 
    $user = $sql->fetch();

        if ($user != NULL) {
            if( $user['password']==md5($password) ){
                $response['status'] = "success";
                $response['message'] = 'Logged in successfully.';
                $response['name'] = $user['name'];
                $response['uid'] = $user['id'];
                $response['email'] = $user['email'];
                if (!isset($_SESSION)) {
                    session_start();
                }
                $_SESSION['nc_uid'] = $user['id'];
                $_SESSION['nc_email'] = $email;
                $_SESSION['nc_name'] = $user['name'];
            } else {
                $response['status'] = "error";
                $response['message'] = 'Login failed. Incorrect credentials';
            }
        }
        else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }

    echoResponse(200, $response);
    $db = null;
});
$app->post('/register', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'name', 'password'),$r->customer);
    
    $db = new PDO("sqlite:db/neardb.sqlite");

    $name = $r->customer->name;
    $email = $r->customer->email;
    $password = $r->customer->password;

    $sql = $db->prepare("select 1 from user where email='".$email."'");
    $sql->execute(); 
    $isUserExists = $sql->fetch();

    if(!$isUserExists){
        $en_password = md5($password);

        $sql_insert = $db->prepare("INSERT INTO user(name,email,password) VALUES('".$name."', '".$email."', '".$en_password."')");

        if ($sql_insert->execute() != NULL) {
            $response["status"] = "success";
            $response["message"] = "User account created successfully";
            $response["id"] = $result;
            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['nc_uid'] = $response["id"];
            $_SESSION['nc_email'] = $name;
            $_SESSION['nc_name'] = $email;

            echoResponse(200, $response);
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to create customer. Please try again";
            echoResponse(201, $response);
        }            
    }else{
        $response["status"] = "error";
        $response["message"] = "An user with the provided phone or email exists!";
        echoResponse(201, $response);
    }
});
$app->get('/logout', function() {
    $n_session = new near_session();
    $session = $n_session->destroySession();
    $response["status"] = "info";
    $response["message"] = "Logged out successfully";
    echoResponse(200, $response);
});
?>