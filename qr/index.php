<?php include '../config/auth.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>QR Menu</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="sidebar">
    <h4><i class="fa-solid fa-crown"></i> OWNER PANEL</h4>
    
    <a href="../dashboard/<?=$_SESSION['role']?>.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    
    <a href="../barang/"><i class="fa-solid fa-box"></i> Data Barang</a>
    <a href="../supplier/"><i class="fa-solid fa-truck"></i> Supplier</a>
    
    <a href="index.php" class="active"><i class="fa-solid fa-qrcode"></i> QR Code</a>
    
    <a href="../stok/"><i class="fa-solid fa-chart-bar"></i> Stok</a>
    <a href="../laporan/"><i class="fa-solid fa-file-invoice"></i> Laporan</a>
    
    <a href="../logout.php" style="margin-top:auto; background: #ef4444; color:white;">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
</div>

<div class="content">
    <h3><i class="fa-solid fa-qrcode"></i> Manajemen QR Code</h3>

    <div class="grid">
        <div class="card">
            <h4><i class="fa-solid fa-plus-square"></i> Generate QR</h4>
            <p>Buat kode QR baru untuk barang yang belum terdaftar.</p>
            <a href="generate.php" class="btn btn-primary">Buka Generate</a>
        </div>

        <div class="card">
            <h4><i class="fa-solid fa-camera"></i> Scan QR</h4>
            <p>Scan QR code menggunakan kamera perangkat Anda.</p>
            <a href="scan.php" class="btn btn-primary">Buka Scanner</a>
        </div>

        <div class="card">
            <h4><i class="fa-solid fa-print"></i> Cetak QR</h4>
            <p>Download dan cetak label QR code untuk ditempel.</p>
            <a href="cetak.php" class="btn btn-primary">Buka Cetak</a>
        </div>
    </div>

</div>
</body>
</html>