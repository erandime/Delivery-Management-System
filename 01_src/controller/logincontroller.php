<?php
    session_start();
    if(!isset($_GET["status"])) {
        ?>
        <script>window.location="../view/login.php"</script>//Prevent access without going through login page
        <?php
    }
    
    include '../model/loginmodel.php';
    $loginObj = new login();
    
    $status = $_GET["status"];
    switch($status) {
       case "login": 
           // Sanitize user inputs to prevent XSS
        $username = htmlspecialchars(trim($_POST["username"]), ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars(trim($_POST["password"]), ENT_QUOTES, 'UTF-8');
           
           try {
               if($username=="") {
                   throw new Exception("Username Cannot be Empty");
               }
               if($password=="") {
                   throw new Exception("Password Cannot be Empty");
               }
               
               $loginResult = $loginObj->validateLogin($username, $password); // Validate Credentials
               
               if($loginResult->num_rows>0) {

                   $userRow = $loginResult->fetch_assoc();      //Convert user record into an associative array
                   $_SESSION["user"] = $userRow;        //Create session for the logged user

                   ?> <script>window.location="../view/homepage.php"</script>
                   <?php        //Upon successful login direct to Homepage
                   
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
           
        case "logout":
        // Destroy session and redirect to login page
            session_unset();
            session_destroy();
            ?>
            <script>window.location="../view/login.php"</script>
            <?php
            exit();

        default:
        ?>
        <script>window.location="../view/login.php"</script>
        <?php
        break;   
    }
    
    
