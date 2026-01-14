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
