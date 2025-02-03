<?php
include_once __DIR__ . '/../commons/dbconnection.php';
$dbConnectionObj = new dbConnection();

class DeliveryModel {
    public function getDeliveries() {
        $con = $GLOBALS["con"];
        $sql = "SELECT d.delivery_id, d.delivery_address, d.delivery_status, d.delivery_schedule, 
                       d.delivery_driver_id, o.orders_id, dr.drivers_name, dr.drivers_contact_no, dr.drivers_daily_quota
                FROM delivery d 
                LEFT JOIN orders o ON d.delivery_order_id = o.orders_id
                LEFT JOIN drivers dr ON d.delivery_driver_id = dr.drivers_id";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }

    public function getAvailableDrivers() {
        $con = $GLOBALS["con"];
        $sql = "SELECT drivers_id, drivers_name 
                FROM drivers 
                WHERE drivers_availability = 1 AND drivers_daily_quota > 0";
        $result = $con->query($sql) or die($con->error);
        return $result;
    }
}
?>
