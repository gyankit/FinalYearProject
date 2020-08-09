<?php
require_once("../server/Android.php");
$server = new Android();

if($_POST['api'] == "login") {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    echo $server->login($user, $pass);
}

if($_POST['api'] == "temphumidity") {
    echo $server->temphumidity();
}

if($_POST['api'] == "changeDeviceStatus") {
    $id = $_POST['id'];
    echo $server->change_device_status($id);
}
?>