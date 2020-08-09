<?php
if($_REQUEST['type']=="") {
    header("location:home.php");
} 
$type = $_REQUEST['type'];
if(strcmp($type, "manual")!=0 and strcmp($type, "auto")!=0) {
    header("location:home.php");
}

require("include/check.php");
require_once("server/Web.php");
$server = new Web();

$roomcount = $server->viewtable("rooms");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("include/head.php") ?>
    <script>
        setTimeout(function(){
            window.location.reload();
        }, 180000);
    </script>
</head>
<body>
<?php include("include/header.php"); ?>

    <div class="container-fluid">
        <section class="alert alert-info mt-2 text-center text-dark font-weight-bold">
        <?php if(strcmp($type, "manual")==0) { ?>
            <p>You have requested for Manual Control<br>Control Devices as you Required</p>
        <?php } else { ?>
            <p>All Devices are Control Automatically but still you can control them manually</p>
        <?php } ?>
        </section>
    	<section class="jumbotron bg-secondary">
        <?php if(!$roomcount) { ?>
            <p class="text-center">No Devices Connected</p>
        <?php } else { while($data = $roomcount->fetch_array()) { ?>  
            <div>
                <button class="btn btn-block btn-warning text-uppercase text-white"><h4><?= $data['name']; ?></h4></button>
                <div class="row mb-3">
                <?php 
                $availabledevice = $server->availabledevice($data['id']);
                if(!$availabledevice) { ?>
                    <p class="text-center">No Devices Connected</p>
                <?php } else { while($data = $availabledevice->fetch_array()) {
                    if($data['state'] == 0) 
                        $status = "OFF";
                    else 
                        $status = "ON";
                    $devicename = $server->devicename($data['did']);
                ?>
                    <div class="card col-md-3 bg-info my-2">
                        <div class="card-body text-center p-0 pt-2">
                            <p class="text-dark h5 text-uppercase"><?= $devicename; ?></p>
                            <hr>
                            <div class="alert alert-info pb-0">
                                <div class="row px-2">
                                    <p class="text-uppercase mr-auto text-danger font-weight-bold">Status</p>
                                    <span class="ml-auto"><?= $status; ?></span>
                                </div>
                                <?php if($data['state'] == 0) { ?>
                                <button class="control-btn btn btn-block btn-danger mb-2 text-white font-weight-bold text-uppercase" value="<?= $data['id']; ?>">ON</button>
                                <?php } else { ?>
                                <button class="control-btn btn btn-block btn-success mb-2 text-white font-weight-bold text-uppercase" value="<?= $data['id']; ?>">OFF</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } } ?>
                </div>
            </div>
        <?php } } ?>
        </section>
    </div>
    
<?php include("include/footer.php"); ?>
<?php include("include/javascript.php") ?>
<script type="text/javascript" src="vendor/js/control.js"></script>
</body>
</html>