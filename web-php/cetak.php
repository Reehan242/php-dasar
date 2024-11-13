<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

//cek session login nya  
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
require 'functions.php';
$dataToPrint = search($_SESSION['searching']);

$mpdf = new \Mpdf\Mpdf();
$htmlToPrint = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Halaman</title>
</head>
<body>
    <h1 style="text-align: center;">Daftar Portfolio '.$_SESSION['searching'].'</h1>
    <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>No.</th>
                <th>Thumbnail</th>
                <th>Project Title</th>
                <th>Project Type</th>
                <th>Tools</th>
                <th>Development Time</th>
                <th>Date Start</th>
                <th>Date Finish</th>
            </tr>';
$i = 1;
foreach($dataToPrint as $row) {
    $htmlToPrint.='<tr>
        <td>'.$i++.'</td>
        <td><img src="img/'. $row["image"] .'" alt="'.$row["image"].'" width="180" height="120"></td>
        <td>'. $row["name"].'</td>
        <td>'. $row["project_type"].'</td>
        <td>'. $row["tools"] .'</td>
        <td>'. $row["dev_time"] .'</td>
        <td>'. $row["date_start"] .'</td>
        <td>'. $row["date_finish"] .'</td>
    </tr>';
}

$htmlToPrint.= '</table>
</body>
</html>';
$mpdf->WriteHTML($htmlToPrint);
$mpdf->Output('list-portfolio.pdf','I');
