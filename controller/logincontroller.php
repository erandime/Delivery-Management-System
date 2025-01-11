<?php
    if(!isset($_GET["status"])) {
        ?>
        <script>window.location="../view/login.php"</script>//Prevent access without going through login page
        <?php
    }
    
    include '../model/loginmodel.php';
    $loginObj = new login(); //Create new login object
    
    $status = $_GET["status"];
    switch($status) {
       case "login": 
           $username = $_POST["username"];
           $password = $_POST["password"];
           
           try {
               if($username=="") {
                   throw new Exception("Username Cannot be Empty");
               }
               if($password=="") {
                   throw new Exception("Password Cannot be Empty");
               }
               
               $loginResult = $loginObj->validateLogin($username, $password); // Validate Credentials
               
               if($loginResult->num_rows>0) {
                   echo "Login Successful";
               } else {
                   throw new Exception("Invalid Username or Password");
               }
           } catch (Exception $ex) {
               $msg = $ex->getMessage();
               $msg = base64_encode($msg); //To encode message sent via URL
               ?>
               <script>window.location="../view/login.php?msg= <?php echo "$msg"; ?>"</script>
               <?php
           }
           
           break;
    }
    
    
