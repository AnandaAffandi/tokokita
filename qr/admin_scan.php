<?php
include '../config/auth.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gnerate QR Code</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="sidebar">
    <h4><i class="fa-solid fa-user-shield"></i> ADMIN PANEL</h4>
    <a href="../dashboard/admin.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="../transaksi/masuk.php"><i class="fa-solid fa-arrow-down"></i> Barang Masuk</a>
    <a href="../transaksi/keluar.php"><i class="fa-solid fa-arrow-up"></i> Barang Keluar</a>
    <a href="../stok/index_admin.php"><i class="fa-solid fa-boxes-stacked"></i> Cek Stok</a>
    <a href="../qr/index_admin.php"><i class="fa-solid fa-expand"></i> Scan QR</a>
    <a href="../logout.php" style="margin-top:auto; background: #ef4444; color:white;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="content">
<h3>Scan QR Code</h3>

<div class="card" style="max-width:400px">
<video id="preview" width="100%"></video>

<input type="text" id="hasil" placeholder="Hasil QR" readonly>

</div>
</div>

<script src="../assets/js/qr-auto.js"></script>
</body>
</html>
