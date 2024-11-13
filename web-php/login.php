<?php
session_start();
require 'functions.php';

// cek cookie
if (isset($_COOKIE['key1']) && isset($_COOKIE['key2'])) {
    $key1 = $_COOKIE['key1'];
    $key2 = $_COOKIE['key2'];

    // ambil username berdasarkan id
    $result = mysqli_query($db_conn, "SELECT username FROM users WHERE id=$key1");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ($key2 === hash('tiger128,3', $row['username'])) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $row['username'];
    }
}

//cek session login nya  
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($db_conn, "SELECT * FROM users WHERE username = '$username'");

    // cek username
    if (mysqli_num_rows($result) === 1) {
        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // set session
            $_SESSION["login"] = true;
            $_SESSION["username"] = $username;

            // cek remember me
            if (isset($_POST["remember"])) {
                //buat cookie

                setcookie('key1', $row['id'], time() + 1800);
                setcookie('key2', hash('tiger128,3', $row['username']), time() + 1800);
            }

            header("Location: index.php");
            exit;
        }
    }

    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
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
                                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Link</a>
                            </li>
                            <li class="nav-item"><br></li>
                        </ul>

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
            <h1 class="display-3 fw-bold">
                LOGIN
            </h1>
        </div>
        <!-- Headings End -->

        <!-- Form Login Start -->
        <div class="container mt-10 mb-5">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" aria-describedby="errorMessage" required>
                    <?php if (isset($error)): ?>
                        <div id="errorMessage" class="form-text text-danger">Incorrect Username/Password</div>
                    <?php endif; ?>

                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg" name="login">Login</button>
                <label for="register" class="form-label ms-3">Dont have account?</label>
                <a href="registrasi.php">Register</a>
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


</body>

</html>