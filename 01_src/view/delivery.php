<?php 
include '../controller/deliverycontroller.php'; 
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery List</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> 
</head>
<body>
    <!-- Navbar -->
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
                    <span class="welcome-text me-3">Welcome, <?php echo $_SESSION["user"]["user_name"]; ?></span>
                    <a href="../controller/logincontroller.php?status=logout" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <h3 class="text-center mb-4">Delivery List</h3>

        <!-- Filter, Sort, and Search Section -->
        <div class="row mb-3">
            <!-- Filter -->
            <div class="col-md-4">
                <div class="d-flex align-items-center">
                    <label for="filterStatus" class="form-label me-2">Filter:</label>
                    <select id="filterStatus" class="form-select form-select-sm">
                        <option value="all">All</option>
                        <option value="Ready to Dispatch">Ready to Dispatch</option>
                        <option value="In Transit">In Transit</option>
                        <option value="Completed">Completed</option>
                        <option value="Driver Assigned">Driver Assigned</option>
                    </select>
                </div>
            </div>

            <!-- Sort -->
            <div class="col-md-4">
                <div class="d-flex align-items-center">
                    <label for="sortSchedule" class="form-label me-2">Sort:</label>
                    <select id="sortSchedule" class="form-select form-select-sm">
                        <option value="asc">Schedule (Ascending)</option>
                        <option value="desc">Schedule (Descending)</option>
                    </select>
                </div>
            </div>

            <!-- Search -->
            <div class="col-md-4">
                <div class="d-flex justify-content-end">
                    <input type="text" id="searchDelivery" class="form-control form-control-sm me-2" placeholder="Search by Delivery ID">
                    <button class="btn btn-primary btn-sm" id="searchButton">Search</button>
                    <button class="btn btn-secondary btn-sm ms-2" id="clearSearchButton">Clear</button>
                </div>
                <div id="errorMessage" class="text-danger mt-2" style="display: none;">Error message placeholder</div>
            </div>
        </div>

        <!-- Delivery Table -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Delivery ID</th>
                        <th>Address</th>
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
                    <?php while ($row = $deliveries->fetch_assoc()) { //Loops through deliveries
                        $isCompleted = $row['delivery_status'] === 'Completed'; //extract delivery status to determine if delivery is completed
                        $isInTransit = $row['delivery_status'] === 'In Transit';
                    ?> 
                    <tr data-delivery-id="<?php echo $row['delivery_id']; ?>"> 
                        <td><?php echo $row['delivery_id']; ?></td> 
                        <td><?php echo $row['delivery_address']; ?></td>
                        <td class="status-column"><?php echo $row['delivery_status']; ?></td>
                        <td><?php echo $row['delivery_schedule']; ?></td>
                        <td> 
                            <select class="form-select form-select-sm driver-dropdown" data-delivery-id="<?php echo $row['delivery_id']; ?>">
                                <option value="">Select Driver</option>
                                <?php foreach ($drivers as $driver) { ?>
                                    <option value="<?php echo $driver['drivers_id']; ?>" 
                                        <?php echo $row['delivery_driver_id'] == $driver['drivers_id'] ? 'selected' : ''; ?>> 
                                        <?php echo $driver['drivers_id']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td id="driverName_<?php echo $row['delivery_id']; ?>"><?php echo $row['drivers_name'] ?? 'N/A'; ?></td>
                        <td id="driverContact_<?php echo $row['delivery_id']; ?>"><?php echo $row['drivers_contact_no'] ?? 'N/A'; ?></td>
                        <td><?php echo $row['orders_id']; ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm save-driver" data-delivery-id="<?php echo $row['delivery_id']; ?>" 
                                <?php echo ($isCompleted || $isInTransit) ? 'disabled' : ''; ?>> 
                                Save
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
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

    <!-- Scripts -->
    <script src="../bootstrap/js/jquery-3.7.1.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/scripts.js"></script>
</body>
</html>
