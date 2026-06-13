<?php
session_start();
include '../config/koneksi.php';

if(isset($_POST['simpan'])){

$nama=$_POST['nama'];
$harga=$_POST['harga'];

mysqli_query($conn,"
INSERT INTO menu
VALUES(
NULL,
'$nama',
'$harga'
)");

header("location:menu.php");
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Tambah Menu</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h3>Tambah Menu</h3>

<form method="POST">

<input
type="text"
name="nama"
class="form-control mb-3"
placeholder="Nama Menu"
required>

<input
type="number"
name="harga"
class="form-control mb-3"
placeholder="Harga"
required>

<button
name="simpan"
class="btn btn-success">
Simpan
</button>

</form>

</div>

</body>
</html>