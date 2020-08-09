<?php
if($_REQUEST['id']=="" or $_REQUEST['email']=="") {
    alert("Error Occur!!!");
    header("location:home.php");
} else {
    $id = $_REQUEST['id'];
    $email = $_REQUEST['email'];
}

require_once("server/Web.php");
$server = new Web();

$reset = $server->resetconfirm($email, $id);
if(!$reset) {
    alert("Error Occur!!!");
    header("location:home.php");
}

function _input($data) 
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $pass1 = _input($_POST['password1']);
    $pass2 = _input($_POST['password2']);
    if ($pass1 != $pass2) {
        alert("Password Not Match!!!");
    } else {
        if($server->passwordreset($email, $pass1)) {
            alert("Password Successfully Changed");
            header("location:home.php");
        } else {
            alert("Error Occur");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("include/head.php") ?>
</head>
<body>
    <div class="container">
        <div class="jumbotron mt-5 row">
            <div class="alert text-center col-md-6">
                <img src="vendor/extra/logo.png" alt="No Pic" width="200px">
                <div class="title">
                    <h3>Password Reset</h3>
                </div>
            </div>
            <form class="form col-md-6" id="login-form" method="POST" action="">
                <div class="alert alert-info text-center text-danger font-weight-bold h4">Welcome to Smart Control</div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">New Password</span>
                    </div>
                    <input type="text" class="form-control" name="password1" placeholder="New Password" aria-label="Password" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon2">Confirm Password</span>
                    </div>
                    <input type="password" class="form-control" name="password2" placeholder="Confirm Password" aria-label="Password" aria-describedby="basic-addon2" required>
                </div>
                <button type="submit" class="btn btn-success col-3" id="submit-btn">Submit</button>
            </form>
            <div class="ml-auto"><a href="login.php">Login Page</a></div>
        </div>
    </div>
<?php include("include/javascript.php") ?>
</body>
</html>