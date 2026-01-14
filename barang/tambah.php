<?php
include '../config/auth.php';
include '../config/database.php';

if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $min  = $_POST['min'];

    mysqli_query($koneksi,
        "INSERT INTO barang 
        VALUES(NULL,'$nama','$stok','$min',NOW())");

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="sidebar">
    <h4><i class="fa-solid fa-crown"></i> OWNER PANEL</h4>
    <a href="../dashboard/owner.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="index.php" class="active"><i class="fa-solid fa-box"></i> Data Barang</a>
    <a href="../supplier/"><i class="fa-solid fa-truck"></i> Supplier</a>
    <a href="../qr/"><i class="fa-solid fa-qrcode"></i> QR Code</a>
    <a href="../stok/"><i class="fa-solid fa-chart-bar"></i> Stok</a>
    <a href="../laporan/"><i class="fa-solid fa-file-invoice"></i> Laporan</a>
    <a href="../logout.php" style="margin-top:auto; background: #ef4444; color:white;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>
<div class="content">
<h3>Tambah Barang</h3>

<form method="POST">
<input type="text" name="nama" placeholder="Nama Barang" required><br><br>
<input type="number" name="stok" placeholder="Stok Awal" required><br><br>
<input type="number" name="min" placeholder="Stok Minimal" required><br><br>

<button name="simpan" class="btn btn-primary">Simpan</button>
</form>

</div>
</body>
</html>
