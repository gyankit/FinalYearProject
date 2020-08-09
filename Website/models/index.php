<?php
require_once("Tables.php");
$table = new Tables();

$tb1 = $table->user();
$tb2 = $table->temperature();
$tb3 = $table->device_list();
$tb4 = $table->room();
$tb5 = $table->device();
//$tb6 = $table->onofftime();

//echo '0'.$tb1.'<br>0'.$tb2.'<br>0'.$tb3.'<br>0'.$tb4.'<br>0'.$tb5;
//exit();

if($tb1 and $tb2 and $tb3 and $tb4 and $tb5) {
	header("location:../autoload.php");
} else {
    header("location:../500.php");
}
?>