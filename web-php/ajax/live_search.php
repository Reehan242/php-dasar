<?php
session_start();
require '../functions.php';

$keyword = $_GET['keyword'] ?? '';
$_SESSION['searching'] = $keyword;

$jumlahDataPerHalaman = 4;
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
    <title>Document</title>
</head>

<body>
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
                        <div><a href="#" class="to-hover btn btn-primary">See Project</a></div>
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
</body>

</html>