<?php
include '../config/database.php';
include '../config/auth.php';
cekRole('owner');

$mulai = $_GET['mulai'];
$akhir = $_GET['akhir'];

// Get summary for header
$masukQuery = mysqli_query($koneksi,
    "SELECT COUNT(*) as total_transaksi, SUM(qty) as total_qty 
     FROM transaksi_masuk 
     WHERE tanggal BETWEEN '$mulai' AND '$akhir'");
$masukData = mysqli_fetch_assoc($masukQuery);

$keluarQuery = mysqli_query($koneksi,
    "SELECT COUNT(*) as total_transaksi, SUM(qty) as total_qty 
     FROM transaksi_keluar 
     WHERE tanggal BETWEEN '$mulai' AND '$akhir'");
$keluarData = mysqli_fetch_assoc($keluarQuery);

// Format date for filename
$startFormatted = date('d-m-Y', strtotime($mulai));
$endFormatted = date('d-m-Y', strtotime($akhir));

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=laporan_transaksi_{$startFormatted}_sd_{$endFormatted}.csv");

$output = fopen("php://output", "w");

// Add UTF-8 BOM for Excel compatibility
fwrite($output, "\xEF\xBB\xBF");

// Header information
fputcsv($output, ["LAPORAN TRANSAKSI TOKO KITA"]);
fputcsv($output, ["Periode: $mulai s/d $akhir"]);
fputcsv($output, ["Tanggal Export: " . date('Y-m-d H:i:s')]);
fputcsv($output, []); // Empty row

// Summary section
fputcsv($output, ["RINGKASAN TRANSAKSI"]);
fputcsv($output, ["Jenis Transaksi", "Jumlah Transaksi", "Total Qty"]);
fputcsv($output, [
    "Barang Masuk", 
    $masukData['total_transaksi'] ?? 0, 
    $masukData['total_qty'] ?? 0
]);
fputcsv($output, [
    "Barang Keluar", 
    $keluarData['total_transaksi'] ?? 0, 
    $keluarData['total_qty'] ?? 0
]);
fputcsv($output, [
    "TOTAL", 
    ($masukData['total_transaksi'] ?? 0) + ($keluarData['total_transaksi'] ?? 0), 
    ($masukData['total_qty'] ?? 0) + ($keluarData['total_qty'] ?? 0)
]);
fputcsv($output, []); // Empty row

// Transaction details header
fputcsv($output, ["DETAIL TRANSAKSI"]);
fputcsv($output, ["No", "Jenis", "Nama Barang", "Qty", "Tanggal", "Keterangan"]);

// Get transaction masuk details
$q1 = mysqli_query($koneksi,
    "SELECT transaksi_masuk.*, barang.nama_barang 
     FROM transaksi_masuk 
     JOIN barang ON transaksi_masuk.id_barang=barang.id
     WHERE tanggal BETWEEN '$mulai' AND '$akhir'
     ORDER BY tanggal ASC");

$counter = 1;
while($data = mysqli_fetch_assoc($q1)){
    fputcsv($output, [
        $counter++,
        "MASUK",
        $data['nama_barang'],
        $data['qty'],
        $data['tanggal'],
        $data['keterangan'] ?? '-'
    ]);
}

// Get transaction keluar details
$q2 = mysqli_query($koneksi,
    "SELECT transaksi_keluar.*, barang.nama_barang 
     FROM transaksi_keluar 
     JOIN barang ON transaksi_keluar.id_barang=barang.id
     WHERE tanggal BETWEEN '$mulai' AND '$akhir'
     ORDER BY tanggal ASC");

while($data = mysqli_fetch_assoc($q2)){
    fputcsv($output, [
        $counter++,
        "KELUAR",
        $data['nama_barang'],
        $data['qty'],
        $data['tanggal'],
        $data['keterangan'] ?? '-'
    ]);
}

// Footer
fputcsv($output, []); // Empty row
fputcsv($output, ["CATATAN:"]);
fputcsv($output, ["1. Laporan ini di-generate otomatis dari sistem Toko Kita"]);
fputcsv($output, ["2. Data berdasarkan periode yang dipilih"]);
fputcsv($output, ["3. Untuk pertanyaan, hubungi administrator sistem"]);

fclose($output);
?>