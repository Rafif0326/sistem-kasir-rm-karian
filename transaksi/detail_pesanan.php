<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login'])) {
    header("location:../auth/login.php");
    exit;
}

$id = $_GET['id'];

$trx = mysqli_query($conn,"
SELECT *
FROM transaksi
WHERE id_transaksi='$id'
");

$t = mysqli_fetch_assoc($trx);

$detail = mysqli_query($conn,"
SELECT *
FROM detail_transaksi
WHERE id_transaksi='$id'
");
?>

<!DOCTYPE html>
<html>
<head>

<title>Detail Pesanan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f5f5f5;
}

.card{
    border:none;
    border-radius:15px;
}

</style>

</head>

<body>

<div class="container mt-4">

<div class="card shadow">

<div class="card-body">

<h3 class="mb-4">
Detail Pesanan
</h3>

<table class="table table-bordered">

<tr>
<th width="200">No Pesanan</th>
<td><?= $t['nomor_pesanan']; ?></td>
</tr>

<tr>
<th>Tanggal</th>
<td><?= $t['tanggal']; ?></td>
</tr>

<tr>
<th>Status</th>
<td><?= $t['status_pesanan']; ?></td>
</tr>

<tr>
<th>Total</th>
<td>Rp <?= number_format($t['total']); ?></td>
</tr>

</table>

<h5 class="mt-4">
Daftar Menu
</h5>

<table class="table table-bordered">

<tr class="table-dark">

<th>Menu</th>
<th>Harga</th>
<th>Qty</th>
<th>Subtotal</th>

</tr>

<?php while($d=mysqli_fetch_assoc($detail)){ ?>

<tr>

<td><?= $d['nama_menu']; ?></td>

<td>
Rp <?= number_format($d['harga']); ?>
</td>

<td>
<?= $d['qty']; ?>
</td>

<td>
Rp <?= number_format($d['subtotal']); ?>
</td>

</tr>

<?php } ?>

</table>

<a href="pesanan.php"
class="btn btn-danger">
Kembali
</a>

</div>

</div>

</div>

</body>
</html>