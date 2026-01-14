<?php
include '../config/database.php';

$tipe = $_POST['tipe'];
$id_barang = $_POST['barang'];
$qty = $_POST['qty'];
$tgl = $_POST['tanggal'];

if($tipe=="masuk"){

    $id_supplier = $_POST['supplier'];

    mysqli_query($koneksi,
        "INSERT INTO transaksi_masuk 
        VALUES(NULL,'$id_barang',
        '$id_supplier','$qty','$tgl')");

    mysqli_query($koneksi,
        "UPDATE barang SET 
        stok = stok + $qty 
        WHERE id='$id_barang'");

    header("Location:masuk.php");

}

if($tipe=="keluar"){

    mysqli_query($koneksi,
        "INSERT INTO transaksi_keluar 
        VALUES(NULL,'$id_barang',
        '$qty','$tgl')");

    mysqli_query($koneksi,
        "UPDATE barang SET 
        stok = stok - $qty 
        WHERE id='$id_barang'");

    header("Location:keluar.php");

}
?>
