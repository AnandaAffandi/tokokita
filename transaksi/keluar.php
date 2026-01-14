<?php
include '../config/auth.php';
include '../config/database.php';
cekRole('admin');

$barang = mysqli_query($koneksi,"SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Barang Keluar</title>
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
    <h3><i class="fa-solid fa-truck-ramp-box"></i> Input Barang Keluar</h3>

    <div class="grid" style="grid-template-columns: 1fr 2fr;">
        
        <div class="card" style="text-align:center;">
            <h4>Scan QR Barang</h4>
            <video id="preview"></video>
            <p style="font-size:12px; color:var(--gray);">Arahkan kamera ke QR Code barang</p>
        </div>

        <div class="card">
            <h4>Form Input Manual</h4>
            <form method="POST" action="proses.php">
                <input type="hidden" name="tipe" value="keluar">

                <div class="form-group">
                    <label>Pilih Barang / Scan QR</label>
                    <select name="barang" id="barang" required>
                        <option value="">-- Pilih Barang --</option>
                        <?php while($b=mysqli_fetch_assoc($barang)): ?>
                        <option value="<?=$b['id']?>"><?=$b['nama_barang']?></option>
                        <?php endwhile ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Jumlah & Tanggal</label>
                    <input type="number" name="qty" placeholder="Jumlah Barang Keluar" required>
                    <input type="date" name="tanggal" required>
                </div>

                <button class="btn btn-primary" style="width:100%">
                    <i class="fa-solid fa-save"></i> Simpan Transaksi
                </button>
            </form>
        </div>

    </div>
</div>

<script src="../assets/js/qr-transaksi.js"></script>
</body>
</html>