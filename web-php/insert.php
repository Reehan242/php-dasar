<?php
session_start();

//cek session login nya  
if (!isset($_SESSION['login']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {
    $_POST['username'] = $_SESSION['username'];
    // cek apakah data berhasil di tambahkan atau tidak
    if (insertProject($_POST) > 0) {
        echo "<script>
                alert('data berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>";
    } else {
        echo "<script>
                alert('data gagal ditambahkan!');
                document.location.href = 'index.php';
            </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Portfolio Data</title>
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
                    class="offcanvas offcanvas-end "
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
                        <form class="d-flex" role="search">
                            <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button></a>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Alert Start -->
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true" data-bs-theme="dark">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-light">
                        <h5 class="modal-title">Logout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-light">
                        <p>Are you sure want to logout?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a href="logout.php"><button type="button" class="btn btn-danger">Logout</button></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Alert End -->
    </div>
    <!-- Navbar End -->

    <!-- Content Start -->
    <div class="div-content">
        <!-- Headings Start -->
        <div class="text-primary text-center">
            <h1 class="display-3 fw-bold">
                CREATE
                <small class=" display-3 text-body-secondary fw-bold">POST</small>
            </h1>
        </div>
        <!-- Headings End -->

        <!-- Form Insert Start -->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Title</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Title of Your Post" required>
            </div>
            <div class="mb-3">
                <label for="short_desc" class="form-label">Short Description</label>
                <textarea class="form-control" id="short_desc" name="short_desc" rows="2" maxlength="128" placeholder="A brief description about your post (Max 128 character)"></textarea>
            </div>
            <div class="mb-3">
                <label for="long_desc" class="form-label">Full Description</label>
                <textarea class="form-control" id="long_desc" name="long_desc" rows="8" placeholder="Full description of your post"></textarea>
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">URL</label>
                <input type="text" class="form-control" id="url" name="url" placeholder="External URL for your post if needed">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Thumbnail Image</label>
                <input class="form-control" type="file" id="image" name="image">
            </div>
            <div class="mb-3">
                <button class="btn btn-primary" type="submit" name="submit">Insert Data</button>
            </div>
        </form>
        <!-- Form Insert End -->
    </div>


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