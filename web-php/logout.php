<?php 
session_start();
setcookie('key1','',time()-3600);
setcookie('key2','',time()-3600);
$_SESSION= [];
session_unset();
session_destroy();

header("Location: index.php");
exit;
