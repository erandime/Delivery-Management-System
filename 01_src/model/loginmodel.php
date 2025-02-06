<?php

include_once '../commons/dbconnection.php';
$dbConnectionObj = new dbConnection(); //Create new dbconnection object

class login{
    public function validateLogin($loginusername, $loginpassword) {
        $con = $GLOBALS["con"]; 
        $loginpassword = sha1($loginpassword);
        
        $sql = "SELECT l.login_username, l.login_password, u.user_name FROM login l, user u WHERE l.user_id = u.user_id "
                . "AND l.login_username = ? AND l.login_password = ?"; //Secure the query using prepared statements to prevent SQLi
        $stmt = $con->prepare($sql); //Prepare the SQL statement
        $stmt->bind_param("ss", $loginusername, $loginpassword);    //Bind parameters
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }
}