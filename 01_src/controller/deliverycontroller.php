<?php
include __DIR__ . '/../model/deliverymodel.php';

class DeliveryController {
    private $deliveryModel;

    public function __construct() {
        $this->deliveryModel = new DeliveryModel(); //creates an instance of deliverymodel
    }

    public function getDeliveries() {
        return $this->deliveryModel->getDeliveries();
    }

    public function getAvailableDrivers() {
        return $this->deliveryModel->getAvailableDrivers();
    }

    //Assigns a driver, restore previous driver's quota, updates database
    public function assignDriver($deliveryId, $newDriverId) {
        $con = $GLOBALS['con']; // Use global database connection
        $dispatcherId = 1; // Current dispatcher ID (can also be set from session if needed)

     
        $con->begin_transaction();// begin transaction to ensure all changes happen together

        try {
            // Fetch the currently assigned driver's id
            $stmt = $con->prepare("SELECT delivery_driver_id FROM delivery WHERE delivery_id = ?");
            $stmt->bind_param("i", $deliveryId);
            $stmt->execute();

            $result = $stmt->get_result();
            if (!$result) {
                throw new Exception("Failed to fetch delivery details.");
            }

            $row = $result->fetch_assoc();
            if (!$row) {
                throw new Exception("Delivery not found.");
            }

            $previousDriverId = $row['delivery_driver_id'];

            // If there's a previous driver assigned, increment their quota
            if ($previousDriverId) {
                $stmt = $con->prepare("UPDATE drivers SET drivers_daily_quota = drivers_daily_quota + 1 WHERE drivers_id = ?");
                $stmt->bind_param("i", $previousDriverId);
                if (!$stmt->execute()) {
                    throw new Exception("Failed to update quota of the previous driver.");
                }
            }

            // Update the delivery table with the new driver and dispatcher ID
            $stmt = $con->prepare("UPDATE delivery SET delivery_driver_id = ?, delivery_status = 'Driver Assigned', dispatcher_id = ? WHERE delivery_id = ?");
            $stmt->bind_param("iii", $newDriverId, $dispatcherId, $deliveryId);
            if (!$stmt->execute()) {
                throw new Exception("Failed to update delivery table.");
            }

            // Decrement the quota of the new driver
            $stmt = $con->prepare("UPDATE drivers SET drivers_daily_quota = drivers_daily_quota - 1 WHERE drivers_id = ? AND drivers_daily_quota > 0");
            $stmt->bind_param("i", $newDriverId);
            if (!$stmt->execute() || $stmt->affected_rows === 0) {
                throw new Exception("Driver is unavailable. Please select a new driver.");
            }

            // Commit transaction
            $con->commit();
            //return success message
            return ['success' => true, 'message' => "Driver assigned successfully, and driver's daily quota updated."];
        } catch (Exception $e) {
            // Rollback transaction on failure
            $con->rollback();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function getDriverDetails($driverId) {
        $con = $GLOBALS['con'];
        $stmt = $con->prepare("SELECT drivers_name, drivers_contact_no FROM drivers WHERE drivers_id = ?");
        $stmt->bind_param("i", $driverId);
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) {
            return null; // Return null if query execution fails
        }

        return $result->fetch_assoc() ?: null;
    }
}

// Create a DeliveryController instance
$deliveryController = new DeliveryController();
$deliveries = $deliveryController->getDeliveries();
$drivers = $deliveryController->getAvailableDrivers();

// Process assignDriver requests from the FE-Handle AJAX POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'assignDriver':
                $deliveryId = intval($_POST['deliveryId']);
                $driverId = intval($_POST['driverId']);
                $response = $deliveryController->assignDriver($deliveryId, $driverId);
                header('Content-Type: application/json');
                echo json_encode($response); //return json response to the FE
                exit();

            case 'getDriverDetails':
                $driverId = intval($_POST['driverId']);
                $driverDetails = $deliveryController->getDriverDetails($driverId);
                header('Content-Type: application/json');
                echo json_encode($driverDetails);
                exit();
        }
    }
}
?>
