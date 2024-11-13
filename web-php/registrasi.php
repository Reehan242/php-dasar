<?php
session_start();
require 'functions.php';
//cek session login nya  
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}



if (isset($_POST["register"])) {

    if (register($_POST) == 1) {
        echo "<script>alert('Account sucessfully created!');</script>";
    } else if (register($_POST) == 50) {
        $error_user = "Username already exist!";
    } else if (register($_POST) == 55) {
        $error_pw = "Password doesnt match!";
    } else {
        echo mysqli_error($db_conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>

</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Navbar Start -->
    <div>
        <nav class="navbar bg-body-tertiary fixed-top" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand  fs-2" href="#">
                    <img src="img/logo.png" alt="Logo" width="32" height="32" class="d-inline-block align-text-center">
                </a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div
                    class="offcanvas offcanvas-end"
                    tabindex="-1"
                    id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">

                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                            <?php if (isset($userdata)) : ?>
                                <?= $userdata[0]['username']; ?>
                            <?php else : ?>
                                Guest
                            <?php endif; ?>

                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Link</a>
                            </li>
                            <li class="nav-item"><br></li>
                        </ul>
                        <form class="d-flex" role="search">
                            <a href="login.php" class="toHide btn btn-success">Login</a>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

    </div>
    <!-- Navbar End -->

    <!-- Content Start -->
    <div class="div-content">
        <!-- Headings Start -->
        <div class="text-primary text-center mt-auto">
            <h1 class="display-1 fw-bold">
                REGISTER
            </h1>
        </div>
        <!-- Headings End -->

        <!-- Form Login Start -->
        <div class="container mt-10 mb-5">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="reg_username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="reg_username" name="reg_username" aria-describedby="errorMessageUsername" required autocomplete="off">
                    <?php if (isset($error_user)) : ?>
                        <div id="errorMessageUsername" class="form-text text-danger"><?= $error_user;?></div>
                    <?php else : ?>
                        <div id="errorMessageUsername" class="form-text text-danger"></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="reg_password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="reg_password1" name="reg_password" required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="reg_password2" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="reg_password2" name="reg_password2" aria-describedby="errorMessagePassword" required autocomplete="off">
                    <?php if (isset($error_pw)) : ?>
                        <div id="errorMessagePassword" class="form-text text-danger"><?= $error_pw;?></div>
                    <?php else: ?>
                        <div id="errorMessagePassword" class="form-text text-danger"></div>
                    <?php endif; ?>

                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>

                <button type="submit" class="btn btn-primary" name="register">Register</button>
            </form>
        </div>
        <!-- Form Login End -->
    </div>
    <!-- Content End -->

    <!-- Footer Start -->
    <footer class="bg-dark py-5 mt-auto">
        <div class="container text-light text-center">
            <p class="display-5 mb-3">This Is Footer</p>
            <small class="text-white-50">&copy;Copyright by Reehan. All rights reserved.</small>
        </div>
    </footer>
    <!-- Footer End -->

    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>