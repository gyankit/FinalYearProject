<?php
Class Tables
{
    protected $conn;

    function __construct()
    {
        require_once("../server/Database.php");
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function user()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `users` ( 
            `id` INT(255) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NOT NULL ,
            `contact` VARCHAR(10) NOT NULL ,
            `email` VARCHAR(50) NOT NULL ,
            `password` VARCHAR(50) NOT NULL ,
            `type` VARCHAR(50) NOT NULL ,
            `privilege` BOOLEAN NOT NULL DEFAULT 0,
            PRIMARY KEY (`id`) ,
            UNIQUE (`email`))";

        if($this->conn->query($sql)) {
            return true;
        }
        return false;
    }

    public function temperature()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `temperatures` ( 
            `id` INT(255) NOT NULL AUTO_INCREMENT,
            `datetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            `temp` VARCHAR(5) NOT NULL ,
            `humidity` VARCHAR(5) NOT NULL ,
            PRIMARY KEY (`id`))";

        if($this->conn->query($sql)) {
            return true;
        }
        return false;
    }

    public function device_list()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `devices_list` ( 
            `id` INT(255) NOT NULL ,
            `name` VARCHAR(100) NOT NULL ,
            PRIMARY KEY (`id`))";

        if($this->conn->query($sql)) {
            if($this->add_to_device_list()) {
                return true;
            }
        }
        return false;
    }

    public function add_to_device_list()
    {
        $sql = "INSERT IGNORE INTO `devices_list` VALUES 
        (1, 'Bulb') ,
        (2, 'Fan') ,
        (3, 'TV') ,
        (4, 'AC') ,
        (5, 'Electric Heater') ,
        (6, 'Refrigerator') ,
        (7, 'Microwave Ovens') ,
        (8, 'Washing Machine') ";

        if($this->conn->query($sql)) {
            return true;
        }
        return false;
    }

    public function room()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `rooms` ( 
            `id` INT(255) NOT NULL AUTO_INCREMENT ,
            `name` VARCHAR(100) NOT NULL ,
            PRIMARY KEY (`id`))";

        if($this->conn->query($sql)) {
            return true;
        }
        return false;
    }

    public function device()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `devices` ( 
            `id` INT(255) NOT NULL ,
            `did` INT(255) NOT NULL ,
            `rid` INT(255) NOT NULL ,
            `current_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            `on_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            `off_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            `state` INT(1) NOT NULL ,
            PRIMARY KEY (`id`) ,
            FOREIGN KEY (`did`) REFERENCES `devices_list`(`id`) ,
            FOREIGN KEY (`rid`) REFERENCES `rooms`(`id`))";

        if($this->conn->query($sql)) {
            return true;
        }
        return false;
    }

    public function onofftime()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `onofftime` ( 
            `id` INT(255) NOT NULL AUTO_INCREMENT ,
            `did` INT(255) NOT NULL ,
            `on_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            `off_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            PRIMARY KEY (`id`) ,
            FOREIGN KEY (`did`) REFERENCES `devices`(`id`))";

        if($this->conn->query($sql)) {
            return true;
        }
        return false;
    }

    function __destruct()
    {
        $this->conn->close();
        unset($this->conn);
    }
}
?>