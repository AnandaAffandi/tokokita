<?php
include '../config/database.php';

$id = $_GET['id'];
mysqli_query($koneksi,"DELETE FROM supplier WHERE id='$id'");

header("Location:index.php");
?>
