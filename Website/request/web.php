<?php
require_once("../server/Web.php");
$server = new Web();

if($_POST['btn'] == "control") {
    $id = $_POST['id'];

    echo $server->change_device_status($id);
}

?>