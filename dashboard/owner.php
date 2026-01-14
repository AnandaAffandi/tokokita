<?php
include '../config/auth.php';
include '../config/database.php';
cekRole('owner');

$jmlBarang = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM barang"));
$jmlSupplier = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM supplier"));
$stokMinim = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang WHERE stok<=stok_minimal"));

// Data tambahan untuk dashboard owner
$todayTransactions = mysqli_num_rows(mysqli_query($koneksi,
    "SELECT * FROM (
        SELECT id, tanggal FROM transaksi_masuk WHERE DATE(tanggal) = CURDATE()
        UNION ALL
        SELECT id, tanggal FROM transaksi_keluar WHERE DATE(tanggal) = CURDATE()
    ) as today_transactions"
));

$stokMinimDetails = mysqli_query($koneksi,
    "SELECT nama_barang, stok, stok_minimal FROM barang WHERE stok <= stok_minimal LIMIT 5"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Owner - Toko Kita</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Additional styles for owner dashboard */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .owner-badge {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .stat-change {
            font-size: 14px;
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .positive {
            color: #10b981;
        }
        
        .negative {
            color: #ef4444;
        }
        
        .stok-list {
            margin-top: 15px;
        }
        
        .stok-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }
        
        .stok-item:last-child {
            border-bottom: none;
        }
        
        .stok-info h5 {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .stok-info span {
            font-size: 12px;
            color: var(--gray);
        }
        
        .stok-badge {
            background: #fee2e2;
            color: #dc2626;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        /* Adjusted grid for 2 cards instead of 3 */
        .adjusted-grid {
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4><i class="fa-solid fa-crown"></i> OWNER PANEL</h4>
    <a href="owner.php" class="active"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="../barang/"><i class="fa-solid fa-box"></i> Data Barang</a>
    <a href="../supplier/"><i class="fa-solid fa-truck"></i> Supplier</a>
    <a href="../qr/"><i class="fa-solid fa-qrcode"></i> QR Code</a>
    <a href="../stok/"><i class="fa-solid fa-chart-bar"></i> Stok</a>
    <a href="../laporan/"><i class="fa-solid fa-file-invoice"></i> Laporan</a>
    <a href="../logout.php" style="margin-top:auto; background: #ef4444; color:white;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="content">
    <!-- Welcome Header -->
    <div class="welcome-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3>Selamat datang, <?= $_SESSION['nama'] ?> 👑</h3>
                <p>Overview lengkap bisnis Anda dalam satu dashboard.</p>
            </div>
            <div class="owner-badge">
                <i class="fa-solid fa-crown"></i> OWNER
            </div>
        </div>
        <div class="quick-actions">
            <a href="../laporan/" class="action-btn">
                <i class="fa-solid fa-chart-pie"></i> Lihat Laporan
            </a>
            <a href="../stok/" class="action-btn">
                <i class="fa-solid fa-exclamation-triangle"></i> Cek Stok
            </a>
            <a href="../qr/" class="action-btn">
                <i class="fa-solid fa-print"></i> Cetak QR
            </a>
        </div>
    </div>
    
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div>
            <h3>Dashboard Owner</h3>
            <p style="color: var(--gray); margin-top: 5px;">Ringkasan bisnis dan statistik inventory</p>
        </div>
        <div style="display: flex; gap: 15px; align-items: center;">
            <div style="background: var(--dark); color: white; padding: 10px 20px; border-radius: 10px;">
                <i class="fa-solid fa-calendar-day"></i> <?= date('d F Y') ?>
            </div>
        </div>
    </div>

    <!-- Enhanced Stats Grid -->
    <div class="enhanced-grid adjusted-grid">
        <div class="enhanced-card">
            <div class="card-icon primary">
                <i class="fa-solid fa-box"></i>
            </div>
            <div class="card-stats">
                <h4>Total Barang</h4>
                <h1><?= $jmlBarang ?></h1>
                <p>Jenis barang dalam inventory</p>
                <div class="progress-container">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <div class="stat-change">
                    <i class="fa-solid fa-arrow-trend-up positive"></i>
                    <span>Semua produk tersedia</span>
                </div>
            </div>
        </div>

        <div class="enhanced-card">
            <div class="card-icon success">
                <i class="fa-solid fa-truck"></i>
            </div>
            <div class="card-stats">
                <h4>Total Supplier</h4>
                <h1><?= $jmlSupplier ?></h1>
                <p>Mitra supplier aktif</p>
                <div class="progress-container">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <div class="stat-change">
                    <i class="fa-solid fa-handshake"></i>
                    <span>Partner bisnis</span>
                </div>
            </div>
        </div>
        
        <div class="enhanced-card warning">
            <div class="card-icon warning">
                <i class="fa-solid fa-exclamation-triangle"></i>
            </div>
            <div class="card-stats">
                <h4>Stok Menipis</h4>
                <h1><?= $stokMinim ?></h1>
                <p>Barang perlu restock</p>
                <div class="progress-container">
                    <div class="progress-bar" style="width: <?= min(($stokMinim/($jmlBarang+1))*100, 100) ?>%"></div>
                </div>
                <div class="stat-change">
                    <i class="fa-solid fa-triangle-exclamation negative"></i>
                    <span>Perlu perhatian</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Stats (Tanpa Nilai Total Stok) -->
    <div class="grid" style="margin-top: 30px; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
        <div class="card">
            <h4><i class="fa-solid fa-exchange-alt"></i> Transaksi Hari Ini</h4>
            <p style="font-size: 28px; font-weight: 800; color: var(--primary); margin: 15px 0;">
                <?= $todayTransactions ?>
            </p>
            <p>Total transaksi masuk & keluar hari ini</p>
            <div class="stat-change">
                <i class="fa-solid fa-bolt"></i>
                <span>Aktivitas hari ini</span>
            </div>
        </div>
        
        <div class="card">
            <h4><i class="fa-solid fa-chart-line"></i> Status Sistem</h4>
            <div style="margin-top: 15px;">
                <div style="display: flex; justify-content: space-between; margin: 10px 0;">
                    <span>Database</span>
                    <span style="color: #10b981; font-weight: 600;">
                        <i class="fa-solid fa-circle-check"></i> Online
                    </span>
                </div>
                <div style="display: flex; justify-content: space-between; margin: 10px 0;">
                    <span>QR Scanner</span>
                    <span style="color: #10b981; font-weight: 600;">
                        <i class="fa-solid fa-circle-check"></i> Ready
                    </span>
                </div>
                <div style="display: flex; justify-content: space-between; margin: 10px 0;">
                    <span>Laporan</span>
                    <span style="color: #10b981; font-weight: 600;">
                        <i class="fa-solid fa-circle-check"></i> Tersedia
                    </span>
                </div>
                <div style="display: flex; justify-content: space-between; margin: 10px 0;">
                    <span>Inventory</span>
                    <span style="color: #10b981; font-weight: 600;">
                        <i class="fa-solid fa-circle-check"></i> Terupdate
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stok Warning Section -->
    <?php if($stokMinim > 0): ?>
    <div class="recent-activity" style="margin-top: 30px; border-left: 5px solid #ef4444;">
        <h4 style="color: #ef4444; margin-bottom: 20px;">
            <i class="fa-solid fa-exclamation-circle"></i> Stok Perlu Perhatian
        </h4>
        <div class="stok-list">
            <?php while($row = mysqli_fetch_assoc($stokMinimDetails)): ?>
            <div class="stok-item">
                <div class="stok-info">
                    <h5><?= $row['nama_barang'] ?></h5>
                    <span>Stok: <?= $row['stok'] ?> | Minimal: <?= $row['stok_minimal'] ?></span>
                </div>
                <div class="stok-badge">
                    <i class="fa-solid fa-triangle-exclamation"></i> Restock
                </div>
            </div>
            <?php endwhile; ?>
            
            <?php if($stokMinim > 5): ?>
            <div style="text-align: center; padding: 15px;">
                <a href="../stok/" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                    <i class="fa-solid fa-arrow-right"></i> Lihat <?= $stokMinim - 5 ?> item lainnya
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quick Links -->
    <div class="grid" style="margin-top: 30px;">
        <div class="card">
            <h4><i class="fa-solid fa-rocket"></i> Aksi Cepat</h4>
            <div style="display: flex; gap: 10px; margin-top: 15px; flex-wrap: wrap;">
                <a href="../barang/tambah.php" class="btn btn-primary" style="padding: 10px 20px;">
                    <i class="fa-solid fa-plus"></i> Tambah Barang
                </a>
                <a href="../supplier/tambah.php" class="btn" style="background: var(--dark-light); color: white; padding: 10px 20px;">
                    <i class="fa-solid fa-user-plus"></i> Tambah Supplier
                </a>
                <a href="../qr/generate.php" class="btn" style="background: #10b981; color: white; padding: 10px 20px;">
                    <i class="fa-solid fa-qrcode"></i> Generate QR
                </a>
            </div>
        </div>
        
        <div class="card">
            <h4><i class="fa-solid fa-bell"></i> Notifikasi Sistem</h4>
            <div style="margin-top: 15px;">
                <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 12px; border-radius: 8px; margin-bottom: 10px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="color: #f59e0b;">
                            <i class="fa-solid fa-info-circle"></i>
                        </div>
                        <div>
                            <p style="font-size: 13px; margin: 0; color: #92400e; font-weight: 500;">
                                Ada <?= $stokMinim ?> barang yang perlu restock
                            </p>
                        </div>
                    </div>
                </div>
                
                <div style="background: #dbeafe; border-left: 4px solid var(--primary); padding: 12px; border-radius: 8px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="color: var(--primary);">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <div>
                            <p style="font-size: 13px; margin: 0; color: var(--dark); font-weight: 500;">
                                <?= $todayTransactions ?> transaksi hari ini
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    // Add active class to current menu
    document.addEventListener('DOMContentLoaded', function() {
        const currentPage = window.location.pathname;
        const links = document.querySelectorAll('.sidebar a');
        
        links.forEach(link => {
            if(link.href.includes(currentPage.split('/').pop())) {
                link.classList.add('active');
            }
        });
        
        // Add animation to stat numbers
        const statNumbers = document.querySelectorAll('.card-stats h1');
        statNumbers.forEach(stat => {
            const originalText = stat.textContent;
            stat.textContent = '0';
            
            let counter = 0;
            const target = parseInt(originalText.replace(/,/g, ''));
            const increment = target / 50;
            
            const updateCounter = () => {
                if(counter < target) {
                    counter += increment;
                    stat.textContent = Math.floor(counter).toLocaleString();
                    setTimeout(updateCounter, 30);
                } else {
                    stat.textContent = originalText;
                }
            };
            
            setTimeout(updateCounter, 500);
        });
    });
</script>
</body>
</html>