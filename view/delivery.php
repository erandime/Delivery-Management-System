<?php 
    session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery List</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">      <!-- Font Awesome for icons -->
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand">Delivery List</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="../view/homepage.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Support</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="welcome-text me-3">Welcome, <?php echo $_SESSION["user"]["user_name"];?></span>  <!--Display current users name next to Welcome -->
                    <button class="btn btn-outline-light btn-sm" id="logoutButton">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>

    
    <div class="container mt-5">
        <h3 class="text-center mb-4">Delivery List</h3>
        
        <!-- Filter, Sort, and Search Section -->
        <div class="row mb-3">
            <!-- Filter and Sort Options -->
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <label for="filterStatus" class="form-label me-2">Filter:</label>
                    <select id="filterStatus" class="form-select form-select-sm me-3">
                        <option value="all">All</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                    <label for="sortOptions" class="form-label me-2">Sort:</label>
                    <select id="sortOptions" class="form-select form-select-sm">
                        <option value="idAsc">ID (Ascending)</option>
                        <option value="idDesc">ID (Descending)</option>
                        <option value="dateAsc">Date (Oldest First)</option>
                        <option value="dateDesc">Date (Newest First)</option>
                    </select>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    <input type="text" id="searchDelivery" class="form-control form-control-sm me-2" placeholder="Search by Delivery ID or Order ID">
                    <button class="btn btn-primary btn-sm" id="searchButton">Search</button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Delivery ID</th>
                        <th>Delivery Address</th>
                        <th>Status</th>
                        <th>Schedule</th>
                        <th>Driver ID</th>
                        <th>Driver Name</th>
                        <th>Driver Contact</th>
                        <th>Order ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="deliveryListTableBody">
                    <!-- Dynamic rows will be added here -->
                </tbody>
            </table>
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
