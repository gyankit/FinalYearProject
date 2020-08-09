<?php
require_once("server/Web.php");
$server = new Web();
$error = "Fill the Form";

if($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $name = _input($_POST['fname']);
    $contact = _input($_POST['contact']);
    $email = _input($_POST['email']);
    $password = _input($_POST['password']);

    if(empty($name)) {
        $error = "Name Required";
    } else if(empty($contact)) {
        $error = "Contact Required";
    } else if(strlen($contact) != 10) {
        $error = "Not a Valid Contact Number";
    } else if(empty($email)) {
        $error = "Email Required";
    } else if(empty($password)) {
        $error = "Password Required";
    } else if(strlen($password) < 8) {
        $error = "Password length must be greather than 7";
    } else {
        $error = $server->newRegister($name, $contact, $email, $password);
        if($error) {
            header("location:login.php");
        } else {
            $error = "Error Occur";
        }
    }
}

function _input($data) 
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("include/head.php") ?>
</head>
<body>
    <div class="container">
        <div class="jumbotron mt-5">
            <div class="card bg-secondary">
                <div class="card-heading text-center mt-5 d-flex justify-content-center">
                    <h3 class="alert alert-info text-danger col-lg-6">SMART CONTROL</h3>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <form class="form col-lg-6" id="login-form" method="POST" action="">
                        <?php if($error != "") { ?>
                        <div class="alert alert-danger text-center" id="error">
                            <?= $error; ?>
                        </div>
                        <?php } ?>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Name</span>
                            </div>
                            <input type="text" class="form-control" name="fname" placeholder="Full Name" aria-label="Name" aria-describedby="basic-addon1" required autofocus>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon2">Contact</span>
                            </div>
                            <input type="text" class="form-control" name="contact" placeholder="Contact Number" aria-label="Contact" aria-describedby="basic-addon2" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">Email</span>
                            </div>
                            <input type="email" class="form-control" name="email" placeholder="Email ID" aria-label="Email" aria-describedby="basic-addon3" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon4">Password</span>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon4" required>
                        </div>
                        <button type="submit" class="btn btn-success col-3" id="register-btn">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include("include/javascript.php") ?>
</body>
</html>