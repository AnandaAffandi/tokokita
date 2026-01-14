<?php include '../config/auth.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen QR Code</title>
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
    <h3><i class="fa-solid fa-qrcode"></i> Manajemen QR Code</h3>

    <div class="grid">
        <div class="card">
            <h4><i class="fa-solid fa-plus-square"></i> Generate QR</h4>
            <p>Buat kode QR baru untuk barang yang belum terdaftar.</p>
            <a href="admin_generate.php" class="btn btn-primary">Buka Generate</a>
        </div>

        <div class="card">
            <h4><i class="fa-solid fa-camera"></i> Scan QR</h4>
            <p>Scan QR code menggunakan kamera perangkat Anda.</p>
            <a href="admin_scan.php" class="btn btn-primary">Buka Scanner</a>
        </div>

        <div class="card">
            <h4><i class="fa-solid fa-print"></i> Cetak QR</h4>
            <p>Download dan cetak label QR code untuk ditempel.</p>
            <a href="admin_cetak.php" class="btn btn-primary">Buka Cetak</a>
        </div>
    </div>

</div>
</body>
</html>