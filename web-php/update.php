<?php 
session_start();

//cek session login nya  
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

require 'functions.php';

// ambil data di url
$id = $_GET["id"];

//query data mahasiswa berdasarkan id
$game_portfolio = query("SELECT * FROM game_portfolio WHERE id = $id")[0];

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"])) {

    // cek apakah data berhasil di ubah atau tidak
    if (update($_POST) > 0) {
        echo "<script>
                alert('data berhasil diubah!');
                document.location.href = 'index.php';
            </script>";
    } else {
        echo "<script>
                alert('data gagal diubah!');
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
    <title>Update Portfolio Data</title>
</head>

<body>
    <h1>Update Portfolio Data</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $game_portfolio["id"];?>">
        <input type="hidden" name="oldImage" value="<?= $game_portfolio["image"];?>">
        <ul>
            <li>
                <label for="name">Project Name</label>
                <input type="text" name="name" id="name" required value="<?= $game_portfolio["name"];?>">
            </li>
            <li>
                <label for="project_type">Project type</label>
                <input type="text" name="project_type" required value="<?= $game_portfolio["project_type"];?>">
            </li>
            <li>
                <label for="tools">Development Tools</label>
                <input type="text" name="tools" id="tools" required value="<?= $game_portfolio["tools"];?>">
            </li>
            <li>
                <label for="dev_time">Development Time</label>
                <input type="text" name="dev_time" id="dev_time" required value="<?= $game_portfolio["dev_time"];?>">
            </li>
            <li>
                <label for="date_start">Date Start</label>
                <input type="date" name="date_start" id="date_start" required value="<?= $game_portfolio["date_start"];?>">
            </li>
            <li>
                <label for="date_finish">Date Finish</label>
                <input type="date" name="date_finish" id="date_finish" required value="<?= $game_portfolio["date_finish"];?>">
            </li>
            <li>
                <label for="image">Thumbnail</label><br>
                <img src="img/<?= $game_portfolio["image"];?>" width="120" alt=""><br>
                <input type="file" name="image" id="image"  >
            </li>
            <button type="submit" name="submit">Update Data</button>
        </ul>
    </form>
</body>

</html>