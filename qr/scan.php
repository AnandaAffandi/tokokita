<?php
include '../config/auth.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Generate QR</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="sidebar">
    <h4><i class="fa-solid fa-crown"></i> OWNER PANEL</h4>
    
    <a href="../dashboard/<?=$_SESSION['role']?>.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    
    <a href="../barang/"><i class="fa-solid fa-box"></i> Data Barang</a>
    <a href="../supplier/"><i class="fa-solid fa-truck"></i> Supplier</a>
    <a href="../qr/"><i class="fa-solid fa-qrcode"></i> QR Code</a>
    
    <a href="index.php" class="active"><i class="fa-solid fa-chart-bar"></i> Stok</a>
    
    <a href="../laporan/"><i class="fa-solid fa-file-invoice"></i> Laporan</a>
    
    <a href="../logout.php" style="margin-top:auto; background: #ef4444; color:white;">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
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
