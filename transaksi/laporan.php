<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login'])){
    header("location:../auth/login.php");
    exit;
}

if($_SESSION['role'] != 'admin'){
    echo "
    <script>
        alert('Akses ditolak! Hanya Admin yang dapat membuka laporan.');
        window.location='../index.php';
    </script>
    ";
    exit;
}

$totalPendapatan = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT SUM(total) as total FROM transaksi"
    )
);
?>

<!DOCTYPE html>
<html>
<head>

<title>Laporan Penjualan</title>

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

</style>

</head>

<body>

<div class="wrapper">

<!-- NAVBAR -->

<nav class="navbar px-3">

    <span class="text-danger fw-bold fs-5">
        Laporan Penjualan
    </span>

    <a href="../index.php"
       class="btn btn-danger">
       Kembali
    </a>

</nav>

<!-- CONTENT -->

<div class="container mt-4 content">

    <div class="row mb-3">

        <div class="col-md-4">

            <div class="card bg-danger text-white shadow">

                <div class="card-body text-center">

                    <h5>Total Pendapatan</h5>

                    <h3>
                        Rp <?= number_format($totalPendapatan['total'] ?? 0); ?>
                    </h3>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h4 class="mb-0">
                    Data Transaksi
                </h4>

                <a href="export_excel.php"
                   class="btn btn-success">
                   Export Excel
                </a>

            </div>

            <table class="table table-bordered table-hover">

                <tr class="table-dark">

                    <th width="60">No</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembalian</th>
                    <th width="120">Detail</th>

                </tr>

                <?php

                $no = 1;

                $data = mysqli_query(
                    $conn,
                    "SELECT * FROM transaksi ORDER BY id_transaksi DESC"
                );

                while($d = mysqli_fetch_assoc($data)){

                ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td><?= $d['tanggal']; ?></td>

                    <td>
                        Rp <?= number_format($d['total']); ?>
                    </td>

                    <td>
                        Rp <?= number_format($d['bayar']); ?>
                    </td>

                    <td>
                        Rp <?= number_format($d['kembalian']); ?>
                    </td>

                    <td>

                        <a href="detail.php?id=<?= $d['id_transaksi']; ?>"
                           class="btn btn-primary btn-sm">

                           Detail

                        </a>

                    </td>

                </tr>

                <?php } ?>

            </table>

        </div>

    </div>

</div>

<!-- FOOTER -->

<footer>
    © 2026 - Andre Radhitya | Rafif Rizki Naufal | Yuda Wahyu
</footer>

</div>

</body>
</html>