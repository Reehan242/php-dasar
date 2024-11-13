<?php
require '../functions.php';

$data = $_GET;
if (!isset($data['username'])){
    $data['username'] = "";
}
if (!isset($data['password'])) {
    $data['password'] = "";
}
if (!isset($data['password2'])) {
    $data['password2'] = "";
}

$error_user="";
$error_pw="";
if(isset($data)){
    if (live_validate_register($data['username'],$data['password'],$data['password2']) == 50) {
        $error_user = "Username already exist!";
        unset($_GET['password'],$_GET['password2']);
    } else if (live_validate_register($data['username'],$data['password'],$data['password2']) == 55) {
        $error_pw = "Password doesnt match!";
        unset($_GET['username']);
    } else{
        unset($error_user,$error_pw);
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php if (isset($error_user) && isset($_GET['username'])): ?>
        <div class="form-text text-danger"><?= $error_user; ?></div>
    <?php elseif (isset($error_pw) && isset($_GET['password']) && isset($_GET['password2'])): ?>
        <div class="form-text text-danger"><?= $error_pw; ?></div>
    <?php else :?>
        <div class="form-text text-danger"></div>
    <?php endif; ?>

</body>

</html>