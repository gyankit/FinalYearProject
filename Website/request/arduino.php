<?php
require_once("../server/Arduino.php");
$server = new Arduino();

$data = json_decode(file_get_contents("php://input"), true);

if($data[0] == "Uploading") {
    if($server->uploadData($data[1], $data[2])){
        echo "Success";
    } else {
        echo "Failure";
    }
}

if($data[0] == "Receiving") {
	$result = $server->device_status();
    if($result === false){
        echo "Failure";
    } else {
        echo json_encode($result);
    }
}
?>