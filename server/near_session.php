<?php

class near_session {

    public function getSession(){
        if (!isset($_SESSION)) {
            session_start();
        }
        $sess = array();
        if(isset($_SESSION['nc_uid']))
        {
            $sess["nc_uid"] = $_SESSION['nc_uid'];
            $sess["nc_name"] = $_SESSION['nc_name'];
            $sess["nc_email"] = $_SESSION['nc_email'];
        }
        else
        {
            $sess["nc_uid"] = '';
            $sess["nc_name"] = 'Guest';
            $sess["nc_email"] = '';
        }
        return $sess;
    }

    public function destroySession(){
        if (!isset($_SESSION)) {
            session_start();
        }
        if(isSet($_SESSION['nc_uid']))
        {
            unset($_SESSION['nc_uid']);
            unset($_SESSION['nc_name']);
            unset($_SESSION['nc_email']);
            $info='info';
            if(isSet($_COOKIE[$info]))
            {
                setcookie ($info, '', time() - $cookie_time);
            }
            $msg="Logged Out Successfully...";
        }
        else
        {
            $msg = "Not logged in...";
        }
        return $msg;
    }
 
}

?>
