<?php
include '../config/auth.php';
include '../config/database.php';
// Memanggil library QR Code (pastikan path ini sesuai dengan folder Anda)
include 'phpqrcode/qrlib.php'; 

cekRole('admin'); // Sesuaikan akses jika admin juga boleh

// Ambil data barang untuk dropdown
$barang = mysqli_query($koneksi,"SELECT * FROM barang");

// Logic Generate QR dalam satu file
$qr_file = "";
$barang_terpilih = "";

if(isset($_POST['generate'])){
    $id_barang = $_POST['id_barang'];
    
    // Ambil detail barang
    $q = mysqli_query($koneksi, "SELECT * FROM barang WHERE id='$id_barang'");
    $d = mysqli_fetch_assoc($q);
    
    // Nama file QR sementara
    $tempdir = "temp/"; // Pastikan folder ini ada atau ubah sesuai kebutuhan
    if (!file_exists($tempdir)) mkdir($tempdir);
    
    $nama_file = $d['nama_barang'].".png";
    $qr_file = $tempdir.$nama_file;
    
    // Isi QR adalah ID Barang (untuk disscan nanti)
    // Parameter: Teks, Output File, Level Koreksi, Ukuran, Margin
    QRcode::png($d['id'], $qr_file, QR_ECLEVEL_H, 10, 2);
    
    $barang_terpilih = $d['nama_barang'];
}
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
    <h3><i class="fa-solid fa-qrcode"></i> Generate QR Code</h3>

    <div class="grid" style="grid-template-columns: 1fr 1fr;">
        
        <div class="card">
            <h4>Pilih Barang</h4>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Nama Barang</label>
                    <select name="id_barang" required>
                        <option value="">-- Pilih Barang --</option>
                        <?php while($b=mysqli_fetch_assoc($barang)): ?>
                        <option value="<?=$b['id']?>"><?=$b['nama_barang']?></option>
                        <?php endwhile ?>
                    </select>
                </div>
                <button type="submit" name="generate" class="btn btn-primary" style="width:100%; margin-top:15px;">
                    <i class="fa-solid fa-gear"></i> Buat QR Code
                </button>
            </form>
        </div>
        
        <div class="card" style="display:flex; align-items:center; justify-content:center; flex-direction:column; text-align:center; min-height:300px;">
            
            <?php if(isset($_POST['generate']) && $qr_file != ""): ?>
                <h4>QR Code Berhasil Dibuat!</h4>
                <p style="margin-bottom:15px; font-weight:bold; color:var(--primary);"><?=$barang_terpilih?></p>
                
                <img src="<?=$qr_file?>" alt="QR Code" style="width:200px; height:200px; border:1px solid #ddd; padding:10px; border-radius:8px;">
                
                <br>
                <a href="<?=$qr_file?>" download="<?=$nama_file?>" class="btn btn-primary" style="margin-top:10px;">
                    <i class="fa-solid fa-download"></i> Download
                </a>

            <?php else: ?>
                <i class="fa-solid fa-image" style="font-size:60px; color:#e2e8f0; margin-bottom:15px;"></i>
                <p style="color:#64748b;">Pilih barang di samping lalu klik tombol untuk melihat preview QR Code di sini.</p>
            <?php endif; ?>

        </div>
    </div>
</div>

</body>
</html>