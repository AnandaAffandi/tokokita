<?php
include '../config/auth.php';
include '../config/database.php';

$data = mysqli_query($koneksi,
"SELECT qr_code.*,barang.nama_barang 
FROM qr_code 
JOIN barang ON qr_code.id_barang=barang.id");
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
<h3>Daftar QR Code</h3>

<table>
<tr>
<th>No</th>
<th>Barang</th>
<th>QR</th>
<th>Aksi</th>
</tr>

<?php $no=1; while($q=mysqli_fetch_assoc($data)): ?>
<tr>
<td><?=$no++?></td>
<td><?=$q['nama_barang']?></td>
<td>
<img src="<?=$q['kode_qr']?>" width="80">
</td>
<td>
<a href="<?=$q['kode_qr']?>" download
class="btn btn-primary">Download</a>
</td>
</tr>
<?php endwhile ?>

</table>

</div>
</body>
</html>
