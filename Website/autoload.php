<?php
require_once("server/Web.php");
$server = new Web();

if($server->usercount()) {
    header("location:login.php");
} else {
    header("location:register.php");
}
?>