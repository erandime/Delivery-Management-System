<?php
include '../model/deliverymodel.php';

class DeliveryController {
    private $deliveryModel;

    public function __construct() {
        $this->deliveryModel = new DeliveryModel();
    }

    public function getDeliveries() {
        return $this->deliveryModel->getDeliveries();
    }

    public function getAvailableDrivers() {
        return $this->deliveryModel->getAvailableDrivers();
    }
    
    public function assignDriver($deliveryId, $newDriverId) {
    $con = $GLOBALS['con']; // Database connection

    // Start transaction
    $con->begin_transaction();

    try {
        // Fetch the currently assigned driver
        $stmt = $con->prepare("SELECT delivery_driver_id FROM delivery WHERE delivery_id = ?");
        $stmt->bind_param("i", $deliveryId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $previousDriverId = $row['delivery_driver_id'];

        // If there's a previous driver assigned, increment their quota
        if ($previousDriverId) {
            $stmt = $con->prepare("UPDATE drivers SET drivers_daily_quota = drivers_daily_quota + 1 WHERE drivers_id = ?");
            $stmt->bind_param("i", $previousDriverId);
            if (!$stmt->execute()) {
                throw new Exception("Unable to update quota for the previous driver.");
            }
        }

        // Update the delivery table with the new driver
        $stmt = $con->prepare("UPDATE delivery SET delivery_driver_id = ?, delivery_status = 'Driver Assigned' WHERE delivery_id = ?");
        $stmt->bind_param("ii", $newDriverId, $deliveryId);
        if (!$stmt->execute()) {
            throw new Exception("Unable to update the delivery table. Please try again later.");
        }

        // Decrement the quota of the new driver
        $stmt = $con->prepare("UPDATE drivers SET drivers_daily_quota = drivers_daily_quota - 1 WHERE drivers_id = ? AND drivers_daily_quota > 0");
        $stmt->bind_param("i", $newDriverId);
        if (!$stmt->execute() || $stmt->affected_rows === 0) {
            throw new Exception("Selected driver is unavailable, please select a different driver.");
        }

        // Commit transaction
        $con->commit();

        return ['success' => true, 'message' => "Driver assigned successfully, and Driver's daily quota updated."];
    } catch (Exception $e) {
        // Rollback transaction on failure
        $con->rollback();
        return ['success' => false, 'message' => $e->getMessage()];
    }
}



}

// Create a DeliveryController instance
$deliveryController = new DeliveryController();
$deliveries = $deliveryController->getDeliveries();
$drivers = $deliveryController->getAvailableDrivers();

// Handle AJAX POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'assignDriver') {
    $deliveryId = intval($_POST['deliveryId']);
    $driverId = intval($_POST['driverId']);

    // Call the assignDriver method
    $response = $deliveryController->assignDriver($deliveryId, $driverId);

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>
