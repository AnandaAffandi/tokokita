<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login/index.php");
    exit;
}

function cekRole($role){

    if($_SESSION['role'] != $role){

        $redirect = "../dashboard/".$_SESSION['role'].".php";

        echo "<script>
            alert('Akses ditolak!');
            window.location='$redirect';
        </script>";

        exit;
    }
}
?>
