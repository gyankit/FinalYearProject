<?php
require("include/check.php");
require_once("server/Web.php");
$server = new Web();

$temphum = json_decode($server->temphumidity());
if($temphum[0] === false){
    $temp_in_C = 0;
    $temp_in_F = 0;
    $humidity = 0;
} else {
    $temp_in_C = $temphum[0];
    $temp_in_F = ((9*$temphum[0])/5 + 32);
    $humidity = $temphum[1];
}
$temp_table = $server->temps();
$user_table = $server->users();
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

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-3 col-md-3 card card-temp">
                <div class="card-body text-center text-dark">
                    <p class="h5">Temperature</p>
                    <hr>
                    <h1 id="temperature" class="text-dark"><?= $temp_in_C.' &#8451;<br>'.$temp_in_F.' &#8457;' ?></h1>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 card card-humd">
                <div class="card-body text-center text-dark">
                    <p class="h5">Humidity</p>
                    <hr>
                    <h1 id="humidity" class="mt-4 text-dark"><?= $humidity.' &#37;'; ?></h1>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 card bg-dark">
                <div class="card-body text-center">
                    <p class="text-white h5">Device Control</p>
                    <hr>
                    <button class="btn btn-success btn-block" id="automatic">Automatic</button>
                    <button class="btn btn-primary btn-block" id="manual" onclick="window.location.href = 'control.php?type=manual';">Manual</button>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 card bg-dark" id="device-display">
                <div class="card-body text-white">
                    <p class="text-center h5 mt-5">To Controlled Devices by Automatic Temperature Sensor</p>
                    <button class="btn btn-sm btn-info btn-block" onclick="window.location.href = 'control.php?type=auto';">Click Here</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row bg-dark p-2 mb-2">
            <button class="btn btn-primary col-6 mr-auto" id="btn-temp">Temperature</button>
            <button class="btn btn-info col-6 ml-auto" id="btn-user">Users</button>
        </div>

        <div class="table-responsive" id="table-temp">
            <table class="table table-striped table-hover table-sm text-center">
                <caption>List of Temperature</caption>
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Current TimeStamp</th>
                        <th scope="col">Temperature</th>
                        <th scope="col">Humidity</th>
                    </tr>
                </thead>
                <tbody id="res-temp">
                <?php 
                if(!$temp_table) { 
                    echo "<tr>No Data Found</tr>"; 
                } else { 
                    $num=0;
                    while ($data = $temp_table->fetch_array()) {
                    $num++; ?>
                    <tr>
                        <td><?= $num; ?></td>
                        <td><?= $data["datetime"]; ?></td>
                        <td><?= $data["temp"]; ?></td>
                        <td><?= $data["humidity"]; ?></td>
                    </tr>
                <?php } } ?>
                </tbody>
            </table>
        </div>

        <div class="table-responsive" id="table-user">
            <table class="table table-striped table-hover table-sm text-center">
                <caption>List of Users</caption>
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Contact Number</th>
                        <th scope="col">Email ID</th>
                        <th scope="col">ACTION</th>
                    </tr>
                </thead>
                <tbody id="res-user">
                <?php 
                if(!$user_table) { 
                    echo "<tr>No Data Found</tr>"; 
                } else { 
                    $num=0;
                    while ($data = $user_table->fetch_array()) {
                    $num++; ?>
                    <tr>
                        <td><?= $num; ?></td>
                        <td><?= $data["name"]; ?></td>
                        <td><?= $data["contact"]; ?></td>
                        <td><?= $data["email"]; ?></td>
                        <td>Comming Soon</td>
                    </tr>
                <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
    
<?php include("include/footer.php"); ?>
<?php include("include/javascript.php") ?>
<script>var th = <?php echo json_encode(array($temp_in_C, $humidity)); ?></script>
<script type="text/javascript" src="vendor/js/home.js"></script>
</body>
</html>