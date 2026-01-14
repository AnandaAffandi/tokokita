<?php
include '../config/auth.php';
include '../config/database.php';
cekRole('owner');

$defaultStart = date('Y-m-d', strtotime('-30 days'));
$defaultEnd = date('Y-m-d');
$summaryData = null;

if(isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])) {
    $tgl_awal = $_GET['tgl_awal'];
    $tgl_akhir = $_GET['tgl_akhir'];
    
    // Query sederhana
    $masuk = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT COUNT(*) as total FROM transaksi_masuk 
         WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'"));
    
    $keluar = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT COUNT(*) as total FROM transaksi_keluar 
         WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'"));
    
    $summaryData = [
        'masuk' => $masuk['total'] ?? 0,
        'keluar' => $keluar['total'] ?? 0,
        'start' => $tgl_awal,
        'end' => $tgl_akhir
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan - Toko Kita</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="sidebar">
    <h4><i class="fa-solid fa-crown"></i> OWNER PANEL</h4>
    <a href="../dashboard/owner.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="../barang/"><i class="fa-solid fa-box"></i> Data Barang</a>
    <a href="../supplier/"><i class="fa-solid fa-truck"></i> Supplier</a>
    <a href="../qr/"><i class="fa-solid fa-qrcode"></i> QR Code</a>
    <a href="../stok/"><i class="fa-solid fa-chart-bar"></i> Stok</a>
    <a href="index.php" class="active"><i class="fa-solid fa-file-invoice"></i> Laporan</a>
    <a href="../logout.php" style="margin-top:auto; background: #ef4444; color:white;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="content">
    <h3><i class="fa-solid fa-chart-line"></i> Laporan Transaksi</h3>
    
    <!-- Filter Card -->
    <div class="card" style="max-width: 500px;">
        <h4><i class="fa-solid fa-filter"></i> Pilih Periode</h4>
        
        <form method="GET" action="">
            <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 5px; font-size: 14px;">Dari</label>
                    <input type="date" name="tgl_awal" 
                           value="<?= isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : $defaultStart ?>" 
                           required style="width: 100%;">
                </div>
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 5px; font-size: 14px;">Sampai</label>
                    <input type="date" name="tgl_akhir" 
                           value="<?= isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : $defaultEnd ?>" 
                           required style="width: 100%;">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                <i class="fa-solid fa-search"></i> Tampilkan Laporan
            </button>
        </form>
    </div>
    
    <?php if($summaryData): ?>
    <!-- Results Section -->
    <div style="margin-top: 30px;">
        <!-- Periode Info -->
        <div style="background: #f0f9ff; padding: 15px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid var(--primary);">
            <p style="margin: 0; color: var(--dark);">
                <i class="fa-solid fa-calendar"></i> Periode: 
                <strong><?= date('d M Y', strtotime($summaryData['start'])) ?></strong> - 
                <strong><?= date('d M Y', strtotime($summaryData['end'])) ?></strong>
            </p>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <div class="card" style="text-align: center; border-top: 4px solid #10b981;">
                <div style="font-size: 32px; color: #10b981; margin-bottom: 10px;">
                    <i class="fa-solid fa-arrow-down"></i>
                </div>
                <h4 style="color: var(--gray); font-size: 14px;">Masuk</h4>
                <h1 style="color: var(--dark); margin: 10px 0;"><?= $summaryData['masuk'] ?></h1>
            </div>
            
            <div class="card" style="text-align: center; border-top: 4px solid #ef4444;">
                <div style="font-size: 32px; color: #ef4444; margin-bottom: 10px;">
                    <i class="fa-solid fa-arrow-up"></i>
                </div>
                <h4 style="color: var(--gray); font-size: 14px;">Keluar</h4>
                <h1 style="color: var(--dark); margin: 10px 0;"><?= $summaryData['keluar'] ?></h1>
            </div>
            
            <div class="card" style="text-align: center; border-top: 4px solid #8b5cf6;">
                <div style="font-size: 32px; color: #8b5cf6; margin-bottom: 10px;">
                    <i class="fa-solid fa-exchange-alt"></i>
                </div>
                <h4 style="color: var(--gray); font-size: 14px;">Total</h4>
                <h1 style="color: var(--dark); margin: 10px 0;"><?= $summaryData['masuk'] + $summaryData['keluar'] ?></h1>
            </div>
        </div>
        
        <!-- Export Button -->
        <div style="text-align: center; margin-top: 30px;">
            <a href="export.php?mulai=<?= $summaryData['start'] ?>&akhir=<?= $summaryData['end'] ?>"
               class="btn" style="background: #10b981; color: white; padding: 12px 30px;">
                <i class="fa-solid fa-download"></i> Download Laporan CSV
            </a>
        </div>
        
        <!-- Note -->
        <div style="background: #fef3c7; padding: 15px; border-radius: 10px; margin-top: 30px; border-left: 4px solid #f59e0b;">
            <p style="margin: 0; color: #92400e; font-size: 14px;">
                <i class="fa-solid fa-info-circle"></i> Laporan berisi semua transaksi masuk dan keluar pada periode yang dipilih.
            </p>
        </div>
    </div>
    <?php else: ?>
    <!-- Welcome State -->
    <div class="card" style="text-align: center; padding: 50px 20px; margin-top: 30px;">
        <div style="font-size: 48px; color: #cbd5e1; margin-bottom: 20px;">
            <i class="fa-solid fa-file-chart-column"></i>
        </div>
        <h4 style="color: var(--dark); margin-bottom: 10px;">Belum Ada Data</h4>
        <p style="color: var(--gray);">Silakan pilih periode tanggal untuk melihat laporan transaksi.</p>
    </div>
    <?php endif; ?>
</div>

<script>
    // Set max date to today
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.querySelector('[name="tgl_awal"]').max = today;
        document.querySelector('[name="tgl_akhir"]').max = today;
        
        // Set min for end date
        document.querySelector('[name="tgl_awal"]').addEventListener('change', function() {
            document.querySelector('[name="tgl_akhir"]').min = this.value;
        });
    });
</script>

</body>
</html>