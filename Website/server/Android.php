<?php
class Android
{
    protected $conn;

    function __construct()
    {
        require_once("Database.php");
        $db = new Database();
        $this->conn = $db->connect();
    }

    function login($user, $pass)
    {
        $pass = md5($pass);
        $sql = "SELECT * FROM `users` WHERE email = '$user'";
        if ($result = $this->conn->query($sql)) {
            if ($result->num_rows > 0) {
                $data = $result->fetch_array();
                if (strcmp($user, $data['email']) == 0) {
                    if (strcmp($pass, $data['password']) == 0) {
                        $msg = "true";
                    } else {
                        $msg =  "Password Not Match";
                    }
                } else {
                    $msg = "Username Not Match";
                }
            } else {
                $msg = "Username/Password not Exists";
            }
        } else {
            $msg = NULL;
        }
        $this->conn->close();
        return $msg;
    }

    public function temphumidity() 
    {
        $sql = "SELECT * FROM `temperatures` ORDER BY id DESC";
        if($result = $this->conn->query($sql)) {
            if($result->num_rows >= 1) {
                $data = $result->fetch_array();
                $json->temp = $data['temp'];
                $json->humd = $data['humidity'];
                $this->conn->close();
                return json_encode($json);
            }
        }
        $this->conn->close();
        return NULL;
    }

    public function device_status($id)
    {
        $sql = "SELECT state FROM `devices` WHERE id='$id'";
        if($result = $this->conn->query($sql)) {
            if($result->num_rows >= 1) {
                $data = $result->fetch_array();
                return $data['state'];
            }
        }
        return false;
    }

    public function change_device_status($id)
    {
        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y-m-d H:i:s');
        $state = $this->device_status($id);
        if($state == 0) {
            $status = 1;
            $time = "on_time";
        } else {
            $status = 0;
            $time = "off_time";
        }
        $sql = "UPDATE `devices` SET `state`='$status', `current_time`='$date', `$time`='$date' WHERE id='$id'";
        if($result = $this->conn->query($sql)) {
            if($status) {
                $msg = "Active";
            } else {
                $msg = "Deactivate";
            }
        } else {
            $msg = NULL;
        }
        $this->conn->close();
        return $msg;
    }
}
?>