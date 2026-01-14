<?php
include '../config/database.php';

/* ambil barang stok menipis */
$q = mysqli_query($koneksi,
"SELECT * FROM barang 
 WHERE stok <= stok_minimal");

$total = mysqli_num_rows($q);
?>

<!-- NOTIFIKASI -->
<a href="../stok/" style="color:white;text-decoration:none;">
    🔔 Stok Menipis 
    <?php if($total>0): ?>
    <span class="badge"><?=$total?></span>
    <?php endif; ?>
</a>

<!-- POPUP DETAIL -->
<?php if($total>0): ?>
<div class="card">
<h4>Barang Stok Menipis</h4>
<ul>
<?php while($d=mysqli_fetch_assoc($q)): ?>
<li>
<?=$d['nama_barang']?> 
(<?=$d['stok']?>)
</li>
<?php endwhile ?>
</ul>
</div>
<?php endif; ?>
