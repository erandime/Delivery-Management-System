<?php

include_once '../commons/dbconnection.php';
$dbConnectionObj = new dbConnection(); //Create new dbconnection object

class login{
    public function validateLogin($loginusername, $loginpassword) {
        $con = $GLOBALS["con"];
        $loginpassword = sha1($loginpassword);
        
        $sql = "SELECT l.login_username, l.login_password, u.user_name FROM login l, user u WHERE l.user_id = u.user_id "
                . "AND l.login_username = '$loginusername' AND l.login_password = '$loginpassword'";
        $result = $con->query($sql) or die ($con->error); //Run query or display error
        return $result;
    }
}