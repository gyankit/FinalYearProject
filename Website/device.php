<?php
require("include/check.php");
require_once("server/Web.php");
$server = new Web();

function _input($data) 
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$msg = '';

if($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if(isset($_POST['add-room'])) {
	    $rname = _input($_POST['rname']);
	    $msg = $server->addroom($rname);
	    if($msg === true) {
	        $msg = "Room Name Successully Added";
	    } else {
	        $msg = "Error Occur";
	    }
	}

	if(isset($_POST['add-device'])) {
		$rname = _input($_POST['room']);
		$dname = _input($_POST['device']);
	    $msg = $server->adddevice($rname, $dname);
	    if($msg === true) {
	        $msg = "New Device Successully Added";
	    } else {
	        $msg = "Error Occur";
	    }
	}
}

$room = $server->viewtable("rooms");
$devices = $server->viewtable("devices_list");
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
    	<section>
	    	<div class="row bg-info p-3 mb-2">
	            <button class="btn btn-secondary col-5" id="btn-room">Add Room</button>
	            <p class="col-2"></p>
	            <button class="btn btn-secondary col-5" id="btn-device">Add Device</button>
	        </div>

	        <div id="room-form">
		        <div class="jumbotron d-flex justify-content-center">
		        	<div class="alert alert-info col-md-8 px-5 py-3">
			        	<div class="heading text-center font-weight-bold bg-dark text-danger p-3">
			        		<h3 class="text-uppercase">Add New Room form</h3>
			        	</div>
		        		<form class="form bg-secondary p-3" method="post" action="">
		                    <div class="form-group">
		        				<label for="room" class="text-white text-uppercase font-weight-bold">Room Name</label>
			        			<input type="text" class="form-control" name="rname" placeholder="Room Name Required" required autofocus>
			        		</div>
		                    <button type="submit" class="btn btn-success btn-sm px-5" name="add-room">ADD</button>
		        		</form>
		        	</div>
		        </div>
	    	</div>

	    	<div id="device-form">
		        <div class="jumbotron d-flex justify-content-center" >
		        	<div class="alert alert-info col-md-8 px-5 py-3">
			        	<div class="heading text-center font-weight-bold bg-dark text-danger p-3">
			        		<h3 class="text-uppercase">Add New device form</h3>
			        	</div>
		        		<form class="form bg-secondary p-3" method="post" action="">
		        			<div class="form-group">
		        				<label for="room" class="text-white text-uppercase font-weight-bold">Room Name</label>
			        			<select class="form-control" name="room" required>
			        				<?php if(!$room) { ?>
			        					<option value="">No Data Found</option>
			        				<?php } else { ?>
			        					<option value="">Select Room</option>
			        				<?php while($data = $room->fetch_array()) { ?>
			        					<option value="<?= $data['id']; ?>"><?= $data['name']; ?></option>
			        				<?php } } ?>
			        			</select>
			        		</div>
		        			<div class="form-group">
		        				<label for="device" class="text-white text-uppercase font-weight-bold">Device Name</label>
			        			<select class="form-control" name="device" required>
			        				<?php if(!$devices) { ?>
			        					<option value="">No Data Found</option>
			        				<?php } else { ?>
			        					<option value="">Select Room</option>
			        				<?php while($data = $devices->fetch_array()) { ?>
			        					<option value="<?= $data['id']; ?>"><?= $data['name']; ?></option>
			        				<?php } } ?>
			        			</select>
			        		</div>
	                        <button type="submit" class="btn btn-success btn-sm px-5" name="add-device">ADD</button>
		        		</form>
		        	</div>
		        </div>
		    </div>

	        <?php if($msg != "") { ?>
	        <div class="alert text-center font-weight-bold alert-msg"><p><?= $msg; ?></p></div>
	    	<?php } ?>
		</section>
		<section class="jumbotron">
		<?php if(!$roomcount) { ?>
			<p class="text-center">No Devices Connected</p>
		<?php } else { while($data = $roomcount->fetch_array()) { ?>  
			<div>
				<button class="btn btn-block btn-dark text-uppercase text-white"><h4><?= $data['name']; ?></h4></button>
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
			                    	<p class="text-uppercase mr-auto text-danger font-weight-bold">ID</p>
			                    	<span class="ml-auto"><?= $data['id']; ?></span>
		                    	</div>
		                    	<div class="row px-2">
			                    	<p class="text-uppercase mr-auto text-danger font-weight-bold">Status</p>
			                    	<span class="ml-auto"><?= $status; ?></span>
		                    	</div>
		                    	<p class="text-dark h6">Last Time</p>
		                    	<div class="row px-2">
		                    		<p class="text-uppercase mr-auto text-danger font-weight-bold">On Time</p>
		                    		<span class="ml-auto"><?= $data['on_time']; ?></span>
			                    </div>
			                    <div class="row px-2">
			                    	<p class="text-uppercase mr-auto text-danger font-weight-bold">Off Time</p>
			                    	<span class="ml-auto"><?= $data['off_time']; ?></span>
			                    </div>
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
<script type="text/javascript" src="vendor/js/device.js"></script>
</body>
</html>