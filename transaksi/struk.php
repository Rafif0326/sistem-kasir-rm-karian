<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();
include '../config/koneksi.php';

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

<title>Struk</title>

<style>

body{
font-family:Courier New;
width:350px;
margin:auto;
padding:20px;
}

.center{
text-align:center;
}

.line{
border-top:1px dashed black;
margin:10px 0;
}

table{
width:100%;
font-size:13px;
}

.btn{
padding:10px;
background:#dc3545;
color:white;
border:none;
cursor:pointer;
width:100%;
margin-top:15px;
}

@media print{

.btn{
display:none;
}

}

</style>

</head>

<body>

<div class="center">

<h2>RUMAH MAKAN KARIAN</h2>

Jl. Raya Karian

<hr>

<table width="100%">

<table width="100%" style="font-size:13px;">

<tr>
<td width="40%">No Transaksi</td>
<td width="5%">:</td>
<td>
<?= $id ?>
</td>
</tr>

<tr>
<td>No Pesanan</td>
<td>:</td>
<td>
<?= $t['nomor_pesanan']; ?>
</td>
</tr>

<tr>
<td>Tanggal</td>
<td>:</td>
<td>
<?= date('d-m-Y H:i', strtotime($t['tanggal'])); ?>
</td>
</tr>

</table>

</div>

<div class="line"></div>

<table>

<?php
while($d=mysqli_fetch_assoc($detail)){
?>

<tr>

<td colspan="3">
<?= $d['nama_menu']; ?>
</td>

</tr>

<tr>

<td>
<?= $d['qty']; ?> x
<?= number_format($d['harga']); ?>
</td>

<td></td>

<td align="right">
<?= number_format($d['subtotal']); ?>
</td>

</tr>

<?php } ?>

</table>

<div class="line"></div>

<table>

<tr>

<td>
TOTAL
</td>

<td align="right">
Rp <?= number_format($t['total']); ?>
</td>

</tr>

<tr>

<td>
BAYAR
</td>

<td align="right">
Rp <?= number_format($t['bayar']); ?>
</td>

</tr>

<tr>

<td>
KEMBALI
</td>

<td align="right">
Rp <?= number_format($t['kembalian']); ?>
</td>

</tr>

</table>

<div class="line"></div>

<div class="center">

TERIMA KASIH

<br>

Selamat Menikmati

</div>

<button
onclick="window.print()"
class="btn">

Cetak Struk

</button>

<a
href="../menu/tampil.php"
class="btn-menu">

Transaksi Baru

</a>

</body>
</html>