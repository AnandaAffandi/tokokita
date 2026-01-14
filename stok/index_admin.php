<?php
include '../config/auth.php';
include '../config/database.php';

// Ambil data barang
$data = mysqli_query($koneksi,"SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Monitoring Stok Barang</title>
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

    <h3><i class="fa-solid fa-chart-pie"></i> Monitoring Stok Barang</h3>

    <div class="card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Barang</th>
                        <th>Stok Saat Ini</th>
                        <th>Batas Minimal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no=1;
                    while($b=mysqli_fetch_assoc($data)):

                    // Logic Status
                    if($b['stok'] <= $b['stok_minimal']){
                        $status = "<span class='badge' style='background:#ef4444;'><i class='fa-solid fa-triangle-exclamation'></i> MENIPIS</span>";
                        $bg_row = "style='background:#fff1f2;'";
                    }else{
                        $status = "<span class='badge' style='background:#10b981;'><i class='fa-solid fa-check'></i> AMAN</span>";
                        $bg_row = "";
                    }
                    ?>
                    <tr <?=$bg_row?>>
                        <td><?=$no++?></td>
                        <td><strong><?=$b['nama_barang']?></strong></td>
                        <td><?=$b['stok']?></td>
                        <td><?=$b['stok_minimal']?></td>
                        <td><?=$status?></td>
                    </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>