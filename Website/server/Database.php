<?php
class Database
{
    protected $host, $user, $pass, $database;

    public function __construct()
    {
        $this->host = "localhost";
        /*
        //Username & Password
        $this->user = "id11578530_2k20";
        $this->pass = "Fin@lYe@r";
        //Database Name
        $this->database = "id11578530_2k20";
        */
        //For Production Use
        $this->user = "root";
        $this->pass = "";
        $this->database = "smartcontrol";
    }

    public function connect()
    {
        $conn = new mysqli($this->host, $this->user, $this->pass, $this->database);
        if (mysqli_connect_errno()) {
            header("location:../503.php");
        } else {
            return $conn;
        }
    }
}
?>
