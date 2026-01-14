<?php
include '../config/auth.php';
include '../config/database.php';

$id = $_GET['id'];
$q  = mysqli_query($koneksi,"SELECT * FROM barang WHERE id='$id'");
$d  = mysqli_fetch_assoc($q);

if(isset($_POST['update'])){
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $min  = $_POST['min'];

    mysqli_query($koneksi,
        "UPDATE barang SET 
        nama_barang='$nama',
        stok='$stok',
        stok_minimal='$min'
        WHERE id='$id'");

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="sidebar">
    <h4><i class="fa-solid fa-crown"></i> OWNER PANEL</h4>
    <a href="owner.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="../barang/"><i class="fa-solid fa-box"></i> Data Barang</a>
    <a href="../supplier/"><i class="fa-solid fa-truck"></i> Supplier</a>
    <a href="../qr/"><i class="fa-solid fa-qrcode"></i> QR Code</a>
    <a href="../stok/"><i class="fa-solid fa-chart-bar"></i> Stok</a>
    <a href="../laporan/"><i class="fa-solid fa-file-invoice"></i> Laporan</a>
    <a href="../logout.php" style="margin-top:auto; background: #ef4444; color:white;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="content">
<h3>Edit Barang</h3>

<form method="POST">
<input type="text" name="nama" 
value="<?=$d['nama_barang']?>" required><br><br>

<input type="number" name="stok" 
value="<?=$d['stok']?>" required><br><br>

<input type="number" name="min" 
value="<?=$d['stok_minimal']?>" required><br><br>

<button name="update" class="btn btn-primary">Update</button>
</form>

</div>
</body>
</html>
