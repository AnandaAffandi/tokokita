<?php
include '../config/auth.php';
include '../config/database.php';
cekRole('admin');

$jmlMasuk = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM transaksi_masuk"));
$jmlKeluar = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM transaksi_keluar"));

// Data tambahan untuk dashboard yang lebih informatif
$todayMasuk = mysqli_num_rows(mysqli_query($koneksi, 
    "SELECT * FROM transaksi_masuk WHERE DATE(tanggal) = CURDATE()"
));

$todayKeluar = mysqli_num_rows(mysqli_query($koneksi, 
    "SELECT * FROM transaksi_keluar WHERE DATE(tanggal) = CURDATE()"
));

$totalBarang = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin - Toko Kita</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Additional styles for this page */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .time-display {
            background: var(--dark);
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .stat-trend {
            font-size: 14px;
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .trend-up {
            color: #10b981;
        }
        
        .trend-down {
            color: #ef4444;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4><i class="fa-solid fa-user-shield"></i> ADMIN PANEL</h4>
    <a href="admin.php" class="active"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="../transaksi/masuk.php"><i class="fa-solid fa-arrow-down"></i> Barang Masuk</a>
    <a href="../transaksi/keluar.php"><i class="fa-solid fa-arrow-up"></i> Barang Keluar</a>
    <a href="../stok/index_admin.php"><i class="fa-solid fa-boxes-stacked"></i> Cek Stok</a>
    <a href="../qr/index_admin.php"><i class="fa-solid fa-expand"></i> Scan QR</a>
    <a href="../logout.php" style="margin-top:auto; background: #ef4444; color:white;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="content">
    <!-- Welcome Header -->
    <div class="welcome-header">
        <h3>Selamat datang, <?= $_SESSION['nama'] ?> 👋</h3>
        <p>Selamat bekerja! Berikut adalah ringkasan aktivitas sistem hari ini.</p>
        <div class="quick-actions">
            <a href="../transaksi/masuk.php" class="action-btn">
                <i class="fa-solid fa-plus"></i> Tambah Barang Masuk
            </a>
            <a href="../transaksi/keluar.php" class="action-btn">
                <i class="fa-solid fa-minus"></i> Tambah Barang Keluar
            </a>
            <a href="../qr/index_admin.php" class="action-btn">
                <i class="fa-solid fa-qrcode"></i> Scan QR Code
            </a>
        </div>
    </div>
    
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div>
            <h3>Dashboard Admin</h3>
            <p style="color: var(--gray); margin-top: 5px;">Ringkasan aktivitas dan statistik</p>
        </div>
        <div class="time-display" id="current-time">
            Loading...
        </div>
    </div>

    <!-- Enhanced Stats Grid -->
    <div class="enhanced-grid">
        <div class="enhanced-card">
            <div class="card-icon primary">
                <i class="fa-solid fa-download"></i>
            </div>
            <div class="card-stats">
                <h4>Total Transaksi Masuk</h4>
                <h1><?= $jmlMasuk ?></h1>
                <p>Hari ini: <?= $todayMasuk ?> transaksi</p>
                <div class="progress-container">
                    <div class="progress-bar" style="width: <?= min(($todayMasuk/($jmlMasuk+1))*500, 100) ?>%"></div>
                </div>
                <div class="stat-trend">
                    <i class="fa-solid fa-chart-line trend-up"></i>
                    <span>Total semua transaksi masuk</span>
                </div>
            </div>
        </div>

        <div class="enhanced-card">
            <div class="card-icon danger">
                <i class="fa-solid fa-upload"></i>
            </div>
            <div class="card-stats">
                <h4>Total Transaksi Keluar</h4>
                <h1><?= $jmlKeluar ?></h1>
                <p>Hari ini: <?= $todayKeluar ?> transaksi</p>
                <div class="progress-container">
                    <div class="progress-bar" style="width: <?= min(($todayKeluar/($jmlKeluar+1))*500, 100) ?>%"></div>
                </div>
                <div class="stat-trend">
                    <i class="fa-solid fa-chart-line trend-down"></i>
                    <span>Total semua transaksi keluar</span>
                </div>
            </div>
        </div>
        
        <div class="enhanced-card">
            <div class="card-icon success">
                <i class="fa-solid fa-box"></i>
            </div>
            <div class="card-stats">
                <h4>Total Barang</h4>
                <h1><?= $totalBarang ?></h1>
                <p>Jenis barang dalam sistem</p>
                <div class="progress-container">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <div class="stat-trend">
                    <i class="fa-solid fa-database"></i>
                    <span>Data barang tersedia</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid" style="margin-top: 30px;">
        <div class="card">
            <h4><i class="fa-solid fa-calendar-day"></i> Aktivitas Hari Ini</h4>
            <p style="font-size: 24px; font-weight: 700; color: var(--primary); margin: 15px 0;">
                <?= ($todayMasuk + $todayKeluar) ?> Transaksi
            </p>
            <p>Total transaksi masuk dan keluar hari ini</p>
        </div>
        
        <div class="card">
            <h4><i class="fa-solid fa-clock"></i> Rata-rata per Hari</h4>
            <p style="font-size: 24px; font-weight: 700; color: var(--primary); margin: 15px 0;">
                <?= round(($jmlMasuk + $jmlKeluar) / 30, 1) ?>
            </p>
            <p>Estimasi transaksi per hari (30 hari)</p>
        </div>
    </div>

</div>

<script>
    // Update current time
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        const dateString = now.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        document.getElementById('current-time').innerHTML = 
            `<i class="fa-solid fa-clock"></i> ${timeString} • ${dateString}`;
    }
    
    // Update time every second
    updateTime();
    setInterval(updateTime, 1000);
    
    // Add active class to current menu
    document.addEventListener('DOMContentLoaded', function() {
        const currentPage = window.location.pathname;
        const links = document.querySelectorAll('.sidebar a');
        
        links.forEach(link => {
            if(link.href.includes(currentPage.split('/').pop())) {
                link.classList.add('active');
            }
        });
    });
</script>
</body>
</html>