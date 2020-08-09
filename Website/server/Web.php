<?php
class Web
{
    protected $conn;

    function __construct()
    {
        require_once("Database.php");
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function _input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

//Total User Count
    public function usercount() 
    {
        $sql = "SELECT * FROM `users`";
        if($result = $this->conn->query($sql)) {
            if($result->num_rows >= 1) {
                return true;
            }
        }
        return false;
    }

/* New User Registration */
    public function newRegister($name, $contact, $email, $pass)
    {
        $pass1 = md5($pass);
        if($this->usercount() === false ) { $type="Super"; } else { $type="Admin"; }
        if($type === "Super") {$perm=true;} else {$perm=false;}
        $sql = "INSERT INTO `users` VALUES(NULL, '$name', '$contact', '$email', '$pass1', '$type', '$perm')";
        if($this->conn->query($sql)) {
            if($this->phpmail1($email, $pass)) {
                $msg = true;
            } else {
                $this->removeuser($email);
                $msg = "Error in Sending Mail";
            }   
        } else {
            $msg = "Error Occur";
        }
        $this->conn->close();
        return $msg;
    }

    private function phpmail1($to, $pass)
    {
        $subject = "SMART CONTROL";

        $message = "
            <html>
                <head>
                    <title>New Successfull Registration</title>
                </head>
                <body>
                    <p>Congratulations from SMART CONTROL</p>
                    <p>your username and password are given bellow</p>
                    <p>use given username and password to login on our site and start controlling your home appliances</p>
                    <p>USERNAME : ". $to ."</p>
                    <p>PASSWORD : ". $pass ."</p>
                    <p>WEBSITE LINK : https://final2k20.000webhostapp.com</p>
                </body>
            </html>
            ";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html; charset=UTF-8" . "\r\n";
        // More headers
        $headers .= 'From: g.gyanankit@gmail.com' . "\r\n";

        if(mail($to,$subject,$message,$headers)) {
            return true;
        }
        return true;
    }

    private function removeuser($email)
    {
        $sql = "DELETE FROM `users` WHERE email='$email'";
        $this->conn->query($sql);
    }
/*********************************************/

/*Password Reset*/
    public function forgetpassword($email)
    {
        $sql = "SELECT * FROM `users` WHERE email='$email'";
        if($result = $this->conn->query($sql)) {
            if($result->num_rows >= 1) {
                $data = $result->fetch_array();
                if($this->phpmail2($email, md5($data['id']))) {
                    return true;
                }
            }
        }
        return false;
    }

    private function phpmail2($to, $id)
    {
        $subject = "SMART CONTROL";

        $message = "
            <html>
                <head>
                    <title>Password Reset</title>
                </head>
                <body>
                    <p>We Receive a Password reset request from your side</p>
                    <p>To Change your password Copy the bellow link and paste in browser url or <a href='https://final2k20.000webhostapp.com/password.php?id=$id&email=$to'>click here</a></p>
                    <p>Thanks for Enjoying our service</p>
                    <p>LINK : https://final2k20.000webhostapp.com?id=$id&email=$to</p>
                </body>
            </html>
            ";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html; charset=UTF-8" . "\r\n";
        // More headers
        $headers .= 'From: g.gyanankit@gmail.com' . "\r\n";

        if(mail($to,$subject,$message,$headers)) {
            return true;
        }
        return true;
    }

    public function resetconfirm($email, $id)
    {
        $sql = "SELECT id FROM `users` WHERE email='$email'";
        if($result = $this->conn->query($sql)) {
            if($result->num_rows >= 1) {
                $data = $result->fetch_array();
                if($id==md5($data['id'])) {
                    return true;
                }
            }
        }
        return false;
    }

    public function passwordreset($email, $pass)
    {
        $sql = "UPDATE `users` SET password='$pass' WHERE email='$email";
        if($result = $this->conn->query($sql)) {
            return true;
        }
        return false;
    }
/********************************************/

/*User Login*/
    public function newLogin($user, $pass)
    {
        $pass = md5($pass);

        $sql = "SELECT * FROM `users` WHERE email = '$user'";
        if ($result = $this->conn->query($sql)) {
            if ($result->num_rows > 0) {
                $data = $result->fetch_array();
                if (strcmp($user, $data['email']) == 0) {
                    if (strcmp($pass, $data['password']) == 0) {
                        $_SESSION["login"] = "login_success";
                        $_SESSION["username"] = $data['email'];
                        $_SESSION["name"] = $data["name"];
                        $_SESSION["id"] = $data["id"];
                        $msg = true;
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
            $msg = "Error Occur";
        }
        $this->conn->close();
        return $msg;
    }
/**************************************************/

/*Home Page*/
    public function temphumidity() 
    {
        $sql = "SELECT * FROM `temperatures` ORDER BY id DESC";
        if($result = $this->conn->query($sql)) {
            if($result->num_rows >= 1) {
                $data = $result->fetch_array();
                $temp = $data['temp'];
                $humd = $data['humidity'];
                return json_encode(array($temp, $humd));
            }
        }
        return json_encode(array(false));
    }

    public function temps() 
    {
        $sql = "SELECT * FROM `temperatures` ORDER BY id DESC LIMIT 20";
        if($result = $this->conn->query($sql)) {
            if($result->num_rows >= 1) {
                return $result;
            }
        }
        return false;
    }

    public function users() 
    {
        $sql = "SELECT * FROM `users` ORDER BY id ASC";
        if($result = $this->conn->query($sql)) {
            if($result->num_rows >= 1) {
                return $result;
            }
        }
        return false;
    }
/******************************************/

/*Device Page & Control Page*/
    public function viewtable($table)
    {
        $sql = "SELECT * FROM `$table` ORDER BY id ASC";
        if($result = $this->conn->query($sql)) {
            if($result->num_rows >= 1) {
                return $result;
            }
        }
        return false;
    }

    public function availabledevice($id)
    {
        $sql = "SELECT * FROM `devices` WHERE rid='$id' ORDER BY id ASC";
        if($result = $this->conn->query($sql)) {
            if($result->num_rows >= 1) {
                return $result;
            }
        }
        return false;
    }

    public function devicename($id)
    {
        $sql = "SELECT name FROM `devices_list` WHERE id='$id'";
        if($result = $this->conn->query($sql)) {
            if($result->num_rows >= 1) {
                $data = $result->fetch_array();
                return $data['name'];
            }
        }
        return false;
    }

    public function addroom($name)
    {
        $sql = "INSERT INTO `rooms` VALUES (NULL, '$name')";
        if($result = $this->conn->query($sql)) {
            return true;
        }
        return false;
    }

    public function countdevice()
    {
        $sql = "SELECT * FROM `devices` ORDER BY id DESC";
        if($result = $this->conn->query($sql)) {
            if($result->num_rows >= 1) {
                $data = $result->fetch_array();
                $count = $data['id'] + 1;
                return $count;
            }
        }
        return 1;
    }

    public function adddevice($room, $device)
    {
        $count = $this->countdevice();
        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO `devices` VALUES ('$count', '$device', '$room', '$date', '$date', '$date', '0')";
        if($result = $this->conn->query($sql)) {
            return true;
        }
        return false;
    }
/********************************************/

/*Control Page*/
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
            return true;
        }
        return false;
    }
/*******************************************/
}
?>