<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/koneksi.php';

if(!isset($_SESSION['login'])){
    header("location:../auth/login.php");
    exit;
}

if($_SESSION['role'] != 'admin'){
    echo "
    <script>
        alert('Akses ditolak! Hanya Admin yang dapat membuka halaman ini.');
        window.location='../index.php';
    </script>
    ";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Kelola Menu</title>

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

.table{
    background:white;
}

</style>

</head>

<body>

<div class="wrapper">

<!-- NAVBAR -->

<nav class="navbar px-3">

    <span class="text-danger fw-bold fs-5">
        Kelola Menu
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

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h4 class="mb-0">
                    Daftar Menu
                </h4>

                <a href="tambah_menu.php"
                   class="btn btn-success">
                   + Tambah Menu
                </a>

            </div>

            <table class="table table-bordered table-hover">

                <tr class="table-dark">

                    <th width="60">No</th>
                    <th>Nama Menu</th>
                    <th width="180">Harga</th>
                    <th width="180">Aksi</th>

                </tr>

                <?php

                $no=1;

                $data=mysqli_query($conn,
                "SELECT * FROM menu ORDER BY id_menu DESC");

                while($d=mysqli_fetch_assoc($data)){

                ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td><?= $d['nama_menu']; ?></td>

                    <td>
                        Rp <?= number_format($d['harga']); ?>
                    </td>

                    <td>

                        <a href="edit_menu.php?id=<?= $d['id_menu']; ?>"
                           class="btn btn-warning btn-sm">
                           Edit
                        </a>

                        <a href="hapus_menu.php?id=<?= $d['id_menu']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Hapus menu ini?')">
                           Hapus
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