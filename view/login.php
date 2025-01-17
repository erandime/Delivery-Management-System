<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Delivery Management System</title>    
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">    
</head>
<body>
    <div class="container text-center">
        <h1 class="mb-5">DELIVERY MANAGEMENT SYSTEM</h1>
        <div class="col-sm-8 offset-sm-2" id="alertmsg">&nbsp;</div>
        <!--Display the error message from login controller in an alert box above login panel. -->
        <?php
            $msg = "";
            if(isset($_GET["msg"])) {
                $msg = base64_decode($_GET["msg"]);
            }            
            if($msg != "") {
                ?> <div class="col-sm-8 offset-sm-2 alert alert-danger"><?php echo "$msg"; ?></div>
                <?php
            }
        ?>
        
        <div class="login-rectangle">
            <div class="login-header px-3 py-2">
                <h3 class="text-start">Login</h3>
            </div>

            <div class="login-body px-3 py-4">
                <form action="../controller/logincontroller.php?status=login" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="email" class="form-control" id="username" name="username" placeholder="Enter your username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                    </div>
<!--                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember Me</label>
                    </div>-->
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="../bootstrap/js/jquery-3.7.1.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!--<script src="../js/loginvalidation.js"></script>-->        
</body>
</html>
