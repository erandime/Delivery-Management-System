<?php
    if(!isset($_GET["status"])) {
        ?>
        <script>window.location="../view/login.php"</script>//Prevent access without going through login page
        <?php
    }
    
    $status = $_GET["status"];
    switch($status) {
       case "login": 
           $usernamr = $_POST["username"];
           $password = $_GET["password"];
           
           try {
               if($username == "") {
                   throw new Exception("Username Cannot be Empty");
               }
           } catch (Exception $ex) {
               $msg = $ex->getMessage();
               ?>
               <script>window.location="../view/login.php?msg= <?php echo "$msg"; ?>"</script>
               <?php
           }

           break;
    }
?>