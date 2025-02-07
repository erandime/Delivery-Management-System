<?php
class dbConnection {
    public $conn;
    private $hostname = "localhost";
    private $dbusername = "root";
    private $dbpassword = "";
    private $dbname = "msc_sdp_delivery_mgt_cb015490";

    function __construct() {
        $this->conn = new mysqli(
            $this->hostname,
            $this->dbusername,
            $this->dbpassword,
            $this->dbname
        );

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        } else {
            $GLOBALS["con"] = $this->conn;  // Stores the connection in $GLOBALS["con"} for global access
        }
    }
}
