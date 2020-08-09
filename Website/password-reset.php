<?php
session_start();
function check(){
    if((isset($_SESSION['login'])) and 
    (isset($_SESSION['username'])) and 
    (strcmp($_SESSION['login'], "login_success") == 0)) {
        header("location:home.php");
    }
}
check();

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
    $email = _input($_POST['email']);
    $msg = $server->forgetpassword($email);
    if($msg === true) {
        $msg = "Password Reset link is sent to your Registered email<br>open mail and follow the steps";
    } else {
        $msg = "No Data Found";
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
                    <h3>Forget Password</h3>
                </div>
            </div>
            <form class="form col-md-6" id="login-form" method="POST" action="">
                <div class="alert alert-info text-center text-danger font-weight-bold h4">Welcome to Smart Control</div>
                <p class="text-info h6 text-center">To receive a password reset link enter your correct email</p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Email</span>
                    </div>
                    <input type="email" class="form-control" name="email" placeholder="Please Enter Your Email ID" aria-label="Email" aria-describedby="basic-addon1" required>
                </div>
                <button type="submit" class="btn btn-success col-3" id="submit-btn">Submit</button>
                <?php if($msg != "") { ?><p class="text-danger h6" id="error"><?= $msg; ?></p><?php } ?>
            </form>
            <div class="ml-auto"><a href="login.php">Login Page</a></div>
        </div>
    </div>
<?php include("include/javascript.php") ?>
</body>
</html>