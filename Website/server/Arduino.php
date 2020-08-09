<?php
class Arduino
{
    protected $conn;

    function __construct()
    {
        require_once("Database.php");
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function uploadData($temp, $humidity) 
    {
        $sql = "INSERT INTO `temperatures` values(NULL, CURRENT_TIMESTAMP, '$temp', '$humidity')";
        if($this->conn->query($sql)) {
            return true;
        }
        return false;
    }

    public function device_status()
    {
        $sql = "SELECT * FROM `devices`";
        if($result = $this->conn->query($sql)) {
            if($result->num_rows >= 1) {
                $string="";
                while($data = $result->fetch_array()) {
                    $string=$string.$data['state'];
                }
                return $string;
            }
        }
        return false;
    }
}
?>