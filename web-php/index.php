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
if (isset($_SESSION['login']) && isset($_SESSION['username'])) {
    $userdata = getUserData($_SESSION['username']);
}


$jumlahDataPerHalaman = 4;
$keyword = $_SESSION['searching'] ?? '';
$jumlahData = getTotalData($keyword);
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET['page'])) ? $_GET['page'] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
$project_data = getProjectData($keyword, $awalData, $jumlahDataPerHalaman);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
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
                            <?php if (isset($userdata)) : ?>
                                <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button></a>
                            <?php else : ?>
                                <a href="login.php" class="btn btn-success">Login</a>
                            <?php endif; ?>

                        </form>
                    </div>
                </div>
            </div>
        </nav>

    </div>
    <!-- Navbar End -->

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
                    <a href="logout.php"><button type="button" class="btn btn-danger" >Logout</button></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Alert End -->

    <!-- Content Start -->
    <div class="div-content">
        <!-- Headings Start -->
        <div class="text-primary text-center">
            <h1 class="display-3 fw-bold">
                PROJECT
                <small class=" display-3 text-body-secondary fw-bold">SHOWCASE</small>
            </h1>
        </div>
        <!-- Headings End -->

        <!-- Form Search Bar -->
        <div>
            <form class="d-flex mt-3 mb-3 mx-auto text-center w-75" role="search">
                <input class="form-control me-2" type="search" name="keyword" id="keyword" placeholder="Search" aria-label="Search" autocomplete="off">
            </form>
        </div>
        <!-- Form Search Bar End -->

        <!-- Live Search Display Start -->
        <div id="container">
            <!-- Paginasi -->
            <div class="toHide">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php if ($halamanAktif > 1) : ?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $halamanAktif - 1; ?>">Previous</a></li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                            <?php if ($i == $halamanAktif): ?>
                                <li class="page-item active"><a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a></li>
                            <?php else : ?>
                                <li class="page-item"><a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a></li>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <?php if ($halamanAktif < $jumlahHalaman) : ?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $halamanAktif + 1; ?>">Next</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <!-- Paginasi End -->

            <!-- Card Start -->
            <div class="card-group">
                <div class="row">
                    <?php $i = 1;
                    foreach ($project_data as $row) : ?>
                        <div class="mx-auto text-center card border-success border-0 col-md-5 mb-3 bg-transparent">
                            <img src="img/wp.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h3 class="card-title fw-bold text-warning"><?= $row["name"]; ?></h3>
                                <p class="card-text fw-bold text-warning"><?= $row["project_type"]; ?>, created in <?= $row["dev_time"] ?>, using <?= $row["tools"]; ?>.</p>
                                <div><a href="#" class="to-hover-1 btn btn-primary">See Project</a></div>
                            </div>
                            <div class="card-footer">
                                <small class="text-body-secondary fw-bold text-warning">Last updated 3 mins ago</small>
                            </div>
                        </div>
                    <?php $i++;
                    endforeach; ?>
                </div>
            </div>
            <!-- Card End -->
        </div>
        <!-- Live Search Display End -->
        <a href="cetak.php" target="_blank">Cetak</a>
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>