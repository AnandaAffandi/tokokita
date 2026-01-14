<?php
include '../config/auth.php';
include '../config/database.php';
cekRole('owner'); // Biasanya Owner yang kelola master data

$data = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id DESC");
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
    <h3><i class="fa-solid fa-box"></i> Manajemen Data Barang</h3>

    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h4>Daftar Barang Tersedia</h4>
            <a href="tambah.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Barang</a>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Min. Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; while($d=mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><strong><?=$d['nama_barang']?></strong></td>
                        <td><?=$d['stok']?></td>
                        <td><?=$d['stok_minimal']?></td>
                        <td>
                            <a href="edit.php?id=<?=$d['id']?>" class="btn btn-primary" style="padding:5px 10px; font-size:12px;"><i class="fa-solid fa-pen"></i></a>
                            <a href="hapus.php?id=<?=$d['id']?>" class="btn btn-danger" style="padding:5px 10px; font-size:12px;" onclick="return confirm('Yakin hapus?')"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>