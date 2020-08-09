<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand ml-1 text-white font-weight-bold mt-1" href="index.php">
        <img src="vendor/extra/logo.png" alt="No Logo" height="40px">
        &ensp;SMART CONTROL
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <div class="navbar-nav ml-auto mt-2 row">  
            <button type="button" class="btn btn-outline-success text-white nav-item mr-2 mb-1">
                Welcome&ensp;<span class="badge badge-pill badge-success"><?= $_SESSION['name']; ?></span>
            </button>

            <button type="button" class="btn btn-outline-light nav-item mr-2 mb-1" onclick="window.location.href = 'home.php';">Home</button>
            
            <button type="button" class="btn btn-outline-light nav-item mr-2 mb-1" onclick="window.location.href = 'device.php';">Devices</button>

            <button type="button" class="btn btn-outline-light nav-item mr-2 mb-1" onclick="window.location.href = 'register.php';"> Register </button>

            <button type="button" class="btn btn-outline-warning nav-item mr-2 mb-1" onclick="window.location.href = 'logout.php';"> Logout </button>
        </div>
    </div>
</nav>