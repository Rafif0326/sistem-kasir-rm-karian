<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login'])) {
    header("location:../auth/login.php");
    exit;
}

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu='$id'");
$menu = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {

    $nama = $_POST['nama_menu'];
    $harga = $_POST['harga'];

    mysqli_query($conn, "
        UPDATE menu
        SET
        nama_menu='$nama',
        harga='$harga'
        WHERE id_menu='$id'
    ");

    echo "
    <script>
        alert('Menu berhasil diupdate');
        window.location='menu.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Menu</title>

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

<nav class="navbar px-3" style="background:black;">
    <span class="text-danger fw-bold">
        Edit Menu
    </span>

    <a href="menu.php" class="btn btn-danger btn-sm">
        Kembali
    </a>
</nav>

<div class="container mt-5">

    <div class="card shadow p-4">

        <h3 class="mb-4">
            Edit Data Menu
        </h3>

        <form method="POST">

            <label class="mb-2">
                Nama Menu
            </label>

            <input
                type="text"
                name="nama_menu"
                class="form-control mb-3"
                value="<?= $menu['nama_menu']; ?>"
                required
            >

            <label class="mb-2">
                Harga
            </label>

            <input
                type="number"
                name="harga"
                class="form-control mb-3"
                value="<?= $menu['harga']; ?>"
                required
            >

            <button
                name="update"
                class="btn btn-success">
                Simpan Perubahan
            </button>

        </form>

    </div>

</div>

<footer style="
background:black;
color:white;
text-align:center;
padding:10px;
position:fixed;
bottom:0;
width:100%;
">
    © 2026 - Andre Radhitya | Rafif Rizki Naufal | Yuda Wahyu
</footer>

</body>
</html>