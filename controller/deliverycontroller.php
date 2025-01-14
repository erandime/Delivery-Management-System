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
        $stmt = $con->prepare("UPDATE delivery SET delivery_driver_id = ?, delivery_status = 'Driver Assigned' WHERE delivery_id = ?");
        $stmt->bind_param("ii", $driverId, $deliveryId);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Driver assigned successfully.'];
        } else {
            return ['success' => false, 'message' => 'Failed to assign driver.'];
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
