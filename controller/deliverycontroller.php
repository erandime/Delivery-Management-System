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
    
    public function assignDriver($deliveryId, $driverId) {
    $con = $GLOBALS['con']; // Database connection

    // Start transaction
    $con->begin_transaction();

    try {
        // Update the delivery table to assign the driver
        $stmt = $con->prepare("UPDATE delivery SET delivery_driver_id = ?, delivery_status = 'Driver Assigned' WHERE delivery_id = ?");
        $stmt->bind_param("ii", $driverId, $deliveryId);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update delivery table.");
        }

        // Update the drivers table to decrement the drivers_daily_quota
        $stmt = $con->prepare("UPDATE drivers SET drivers_daily_quota = drivers_daily_quota - 1 WHERE drivers_id = ? AND drivers_daily_quota > 0");
        $stmt->bind_param("i", $driverId);
        if (!$stmt->execute() || $stmt->affected_rows === 0) {
            throw new Exception("Failed to update driver's daily quota. The quota might already be zero.");
        }

        // Commit transaction
        $con->commit();

        return ['success' => true, 'message' => "Driver assigned successfully and driver's daily quota updated."];
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
