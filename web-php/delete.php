<?php
session_start();

//cek session login nya  
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

require 'functions.php';

$id = $_GET["id"];

// cek delete
if (delete($id) > 0){
    echo "<script>
                alert('data berhasil dihapus!');
                document.location.href = 'index.php';
            </script>";
} 
else {
        echo "<script>
                alert('data berhasil dihapus!');
                document.location.href = 'index.php';
            </script>";
    }

?>