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
    $sql = $db->prepare("SELECT * FROM user WHERE email='".$email."' AND password='".md5($password)."'");
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
/*$app->post('/signUp', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'name', 'password'),$r->customer);
    require_once 'passwordHash.php';
    $db = new DbHandler();
    $phone = $r->customer->phone;
    $name = $r->customer->name;
    $email = $r->customer->email;
    $address = $r->customer->address;
    $password = $r->customer->password;
    $isUserExists = $db->getOneRecord("select 1 from customers_auth where phone='$phone' or email='$email'");
    if(!$isUserExists){
        $r->customer->password = passwordHash::hash($password);
        $tabble_name = "customers_auth";
        $column_names = array('phone', 'name', 'email', 'password', 'city', 'address');
        $result = $db->insertIntoTable($r->customer, $column_names, $tabble_name);
        if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "User account created successfully";
            $response["uid"] = $result;
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $response["uid"];
            $_SESSION['phone'] = $phone;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
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
});*/
$app->get('/logout', function() {
    $n_session = new near_session();
    $session = $n_session->destroySession();
    $response["status"] = "info";
    $response["message"] = "Logged out successfully";
    echoResponse(200, $response);
});
?>