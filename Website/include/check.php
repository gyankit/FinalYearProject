<?php
session_start();
function check(){
    if((!isset($_SESSION['login'])) or 
    (!isset($_SESSION['username'])) or 
    (strcmp($_SESSION['login'], "login_success") != 0)) {
        header("location:login.php");
    }
}

check();
?>