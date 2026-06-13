<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login'])){
    header("location:../auth/login.php");
    exit;
}

$id = $_GET['id'];

$trx = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT *
FROM transaksi
WHERE id_transaksi='$id'
"));
?>

<!DOCTYPE html>
<html>
<head>

<title>Detail Transaksi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<nav class="navbar bg-dark px-3">

<span class="text-danger fw-bold">
Detail Transaksi
</span>

<a href="laporan.php"
class="btn btn-danger">
Kembali
</a>

</nav>

<div class="container mt-4">

<div class="card shadow">

<div class="card-body">

<h4>
Transaksi #<?= $trx['id_transaksi']; ?>
</h4>

<p>
Tanggal :
<?= $trx['tanggal']; ?>
</p>

<hr>

<table class="table table-bordered">

<tr class="table-dark">

<th>Menu</th>
<th>Harga</th>
<th>Qty</th>
<th>Subtotal</th>

</tr>

<?php

$detail = mysqli_query($conn,"
SELECT *
FROM detail_transaksi
WHERE id_transaksi='$id'
");

while($d = mysqli_fetch_assoc($detail)){

?>

<tr>

<td><?= $d['nama_menu']; ?></td>

<td>
Rp <?= number_format($d['harga']); ?>
</td>

<td><?= $d['qty']; ?></td>

<td>
Rp <?= number_format($d['subtotal']); ?>
</td>

</tr>

<?php } ?>

</table>

<h4 class="text-danger">
Total :
Rp <?= number_format($trx['total']); ?>
</h4>

<h5>
Bayar :
Rp <?= number_format($trx['bayar']); ?>
</h5>

<h5>
Kembalian :
Rp <?= number_format($trx['kembalian']); ?>
</h5>

</div>

</div>

</div>

</body>
</html>