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

$error = '';

if($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $email = _input($_POST['email']);
    $password = _input($_POST['password']);

    if(empty($email)) {
        $error = "Email Required";
    } else if(empty($password)) {
        $error = "Password Required";
    } else if(strlen($password) < 8) {
        $error = "Password length must be greather than 7";
    } else {
        $login = $server->newLogin($email, $password);
        if($login === true) {
            header("location:home.php");
        } else {
            $error = $login;
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
                    <h3>Login</h3>
                </div>
            </div>
            <form class="form col-md-5" id="login-form" method="POST" action="">
                <div class="alert alert-info text-center text-danger font-weight-bold h4">Welcome to Smart Control</div>
                <?php if($error != "") { ?><p class="text-danger h6" id="error"><?= $error; ?></p><?php } ?>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Email</span>
                    </div>
                    <input type="email" class="form-control" name="email" placeholder="Email ID" aria-label="Email" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon2">Password</span>
                    </div>
                    <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2" required>
                </div>
                <button type="submit" class="btn btn-success col-3" id="login-btn">Login</button>
            </form>
            <div class="ml-auto"><a href="password-reset.php">Forget Password ?</a></div>
        </div>
    </div>
<?php include("include/javascript.php") ?>
</body>
</html>