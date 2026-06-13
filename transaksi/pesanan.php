<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login'])) {
    header("location:../auth/login.php");
    exit;
}

// UBAH STATUS
if(isset($_GET['id']) && isset($_GET['status'])){

    $id = $_GET['id'];
    $status = $_GET['status'];

    mysqli_query($conn,"
        UPDATE transaksi
        SET status_pesanan='$status'
        WHERE id_transaksi='$id'
    ");

    header("location:pesanan.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Manajemen Pesanan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

html,body{
    height:100%;
}

body{
    background:#f5f5f5;
}

.wrapper{
    min-height:100%;
    display:flex;
    flex-direction:column;
}

.content{
    flex:1;
}

.navbar{
    background:black;
}

.card{
    border:none;
    border-radius:15px;
}

footer{
    background:black;
    color:white;
    text-align:center;
    padding:12px;
}

.badge-status{
    font-size:14px;
}

</style>

</head>

<body>

<div class="wrapper">

<!-- NAVBAR -->

<nav class="navbar px-3">

    <span class="text-danger fw-bold fs-5">
        Manajemen Pesanan
    </span>

    <a href="../index.php"
       class="btn btn-danger">
       Kembali
    </a>

</nav>

<!-- CONTENT -->

<div class="container mt-4 content">

<div class="card shadow">

<div class="card-body">

<h4 class="mb-3">
Daftar Pesanan
</h4>

<div class="table-responsive">

<table class="table table-bordered table-hover">

<tr class="table-dark">

<th>No</th>
<th>ID Transaksi</th>
<th>Tanggal</th>
<th>Total</th>
<th>Status</th>
<th width="350">Aksi</th>

</tr>

<?php

$no = 1;

$data = mysqli_query($conn,"
SELECT *
FROM transaksi
ORDER BY id_transaksi DESC
");

while($d=mysqli_fetch_assoc($data)){

?>

<tr>

<td><?= $no++; ?></td>

<td>
TRX-<?= str_pad($d['id_transaksi'],5,'0',STR_PAD_LEFT); ?>
</td>

<td>
<?= $d['tanggal']; ?>
</td>

<td>
Rp <?= number_format($d['total']); ?>
</td>

<td>

<?php

if($d['status_pesanan']=='Diproses'){
    echo '<span class="badge bg-warning text-dark badge-status">Diproses</span>';
}
elseif($d['status_pesanan']=='Dimasak'){
    echo '<span class="badge bg-primary badge-status">Dimasak</span>';
}
else{
    echo '<span class="badge bg-success badge-status">Selesai</span>';
}

?>

</td>

<td>

<a href="?id=<?= $d['id_transaksi']; ?>&status=Diproses"
class="btn btn-warning btn-sm">
Diproses
</a>

<a href="?id=<?= $d['id_transaksi']; ?>&status=Dimasak"
class="btn btn-primary btn-sm">
Dimasak
</a>

<a href="?id=<?= $d['id_transaksi']; ?>&status=Selesai"
class="btn btn-success btn-sm">
Selesai
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</div>

<footer>
© 2026 - Andre Radhitya | Rafif Rizki Naufal | Yuda Wahyu
</footer>

</div>

</body>
</html>