<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");//if user is not logged in -> Redirect to login
    exit();
}
?> 

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispatcher's Homepage</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">      <!-- Font Awesome for icons -->
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dispatcher Homepage</a>

            <!-- Toggler Button (visible on small screens)-->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation links -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Left side: Nav Links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    
                    <li class="nav-item">
                        <a class="nav-link" href="../view/delivery.php">Delivery List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Support</a>
                    </li>
                </ul>

                <!--Welcome, Username, Logout -->
                <div class="d-flex align-items-center">
                    <span class="welcome-text me-3">Welcome, <?php echo $_SESSION["user"]["user_name"];?></span>     <!--Display current users name next to Welcome -->
                    <a href="../controller/logincontroller.php?status=logout" class="btn btn-outline-light btn-sm"> <!-- Handles logout -->
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>

                <!-- Date-Time Rectangle (visible on small screens)-->
                <div id="dateTimeInNav" class="d-none d-lg-none mt-3">
                    <div class="date-time-rectangle">
                        <p class="day" id="currentDay"></p>
                        <p class="date" id="currentDate"></p>
                        <p class="time" id="currentTime"></p>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    
    <div class="container-fluid mt-3">
        <div class="row">
            
            <div class="col-md-8">
                <h3 class="section-caption text-center mb-4">
                    Delivery Overview
                </h3>
                <div class="row mb-3">
                    <div class="col-md-4 d-flex justify-content-center">
                        <div class="delivery-box">
                            <p class="title">Total Deliveries</p>
                            <p class="value" id="totalDeliveries">10</p>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center">
                        <div class="delivery-box">
                            <p class="title">Pending Deliveries</p>
                            <p class="value" id="pendingDeliveries">8</p>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center">
                        <div class="delivery-box">
                            <p class="title">Completed Deliveries</p>
                            <p class="value" id="completedDeliveries">2</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Day and Time Rectangle (visible on large screens) -->
            <div class="col-md-4 d-none d-lg-flex justify-content-end">
                <div class="date-time-rectangle">
                    <p class="day" id="currentDayLarge"></p>
                    <p class="date" id="currentDateLarge"></p>
                    <p class="time" id="currentTimeLarge"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">© 2025 Dispatcher System. All Rights Reserved.</span>
        </div>
    </footer>

    <script src="../bootstrap/js/jquery-3.7.1.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/scripts.js"></script> 
</body>
</html>
