<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login'])) {
    header("location:../auth/login.php");
    exit;
}

// TAMBAH KE KERANJANG
if (isset($_POST['tambah_semua'])) {

    foreach ($_POST['qty'] as $id => $qty) {

        if ($qty > 0) {

            $_SESSION['keranjang'][] = [
                'nama' => $_POST['nama'][$id],
                'harga' => $_POST['harga'][$id],
                'qty' => $qty
            ];
        }
    }

    $_SESSION['notif'] = "Menu berhasil ditambahkan ke keranjang";
    header("Location: tampil.php");
    exit;
}

// HITUNG ITEM KERANJANG
$jumlah_item = 0;

if (!empty($_SESSION['keranjang'])) {

    foreach ($_SESSION['keranjang'] as $item) {

        $jumlah_item += $item['qty'];

    }

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Kasir Rumah Makan Karian</title>

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

footer{
    background:black;
    color:white;
    text-align:center;
    padding:10px;
}

.card-menu{
    border:none;
    border-radius:15px;
    transition:.3s;
}

.card-menu:hover{
    transform:translateY(-3px);
}

.qty-box{
    width:80px;
    text-align:center;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button{
    -webkit-appearance:none;
    margin:0;
}

input[type=number]{
    -moz-appearance:textfield;
}

</style>

</head>

<body>

<div class="wrapper">

<!-- NAVBAR -->

<nav class="navbar px-3" style="background:black;">

    <a href="../index.php" class="btn btn-danger btn-sm">
        Kembali
    </a>

    <span class="mx-auto text-danger fw-bold fs-5">
        Kasir Rumah Makan Karian
    </span>

    <a href="keranjang.php" class="btn btn-danger btn-sm position-relative">

        Keranjang

        <?php if($jumlah_item > 0){ ?>

        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
            <?= $jumlah_item ?>
        </span>

        <?php } ?>

    </a>

</nav>

<!-- CONTENT -->

<div class="container mt-4 content">

<?php if(isset($_SESSION['notif'])){ ?>

<div class="alert alert-success alert-dismissible fade show">

    <?= $_SESSION['notif']; ?>

    <button
    type="button"
    class="btn-close"
    data-bs-dismiss="alert">
    </button>

</div>

<?php
unset($_SESSION['notif']);
}
?>

<!-- SEARCH -->

<input
type="text"
id="cariMenu"
class="form-control mb-4"
placeholder="Cari menu...">

<form method="POST">

<!-- MAKANAN -->

<div class="card shadow mb-4">

<div class="card-header bg-danger text-white fw-bold">
🍽️ Menu Makanan
</div>

<div class="card-body">

<?php

$makanan = mysqli_query($conn,"
SELECT *
FROM menu
WHERE nama_menu NOT LIKE '%Jus%'
AND nama_menu NOT LIKE '%Teh%'
");

while($d=mysqli_fetch_array($makanan)){

?>

<div class="card card-menu shadow-sm mb-2 item-menu">

<div class="card-body d-flex justify-content-between align-items-center">

<div>

<h6 class="mb-1">
<?= $d['nama_menu']; ?>
</h6>

<small class="text-muted">
Rp <?= number_format($d['harga']); ?>
</small>

</div>

<div class="d-flex align-items-center">

<div class="input-group" style="width:130px;">

<button
type="button"
class="btn btn-outline-danger"
onclick="kurang(<?= $d['id_menu']; ?>)">
-
</button>

<input
type="number"
name="qty[<?= $d['id_menu']; ?>]"
id="qty<?= $d['id_menu']; ?>"
value="0"
min="0"
class="form-control text-center">

<button
type="button"
class="btn btn-outline-success"
onclick="tambah(<?= $d['id_menu']; ?>)">
+
</button>

</div>

<input
type="hidden"
name="nama[<?= $d['id_menu']; ?>]"
value="<?= $d['nama_menu']; ?>">

<input
type="hidden"
name="harga[<?= $d['id_menu']; ?>]"
value="<?= $d['harga']; ?>">

</div>

</div>

</div>

<?php } ?>

</div>
</div>

<!-- MINUMAN -->

<div class="card shadow">

<div class="card-header bg-dark text-white fw-bold">
🥤 Menu Minuman
</div>

<div class="card-body">

<?php

$minuman = mysqli_query($conn,"
SELECT *
FROM menu
WHERE nama_menu LIKE '%Jus%'
OR nama_menu LIKE '%Teh%'
");

while($d=mysqli_fetch_array($minuman)){

?>

<div class="card card-menu shadow-sm mb-2 item-menu">

<div class="card-body d-flex justify-content-between align-items-center">

<div>

<h6 class="mb-1">
<?= $d['nama_menu']; ?>
</h6>

<small class="text-muted">
Rp <?= number_format($d['harga']); ?>
</small>

</div>

<div class="d-flex align-items-center">

<div class="input-group" style="width:130px;">

<button
type="button"
class="btn btn-outline-danger"
onclick="kurang(<?= $d['id_menu']; ?>)">
-
</button>

<input
type="number"
name="qty[<?= $d['id_menu']; ?>]"
id="qty<?= $d['id_menu']; ?>"
value="0"
min="0"
class="form-control text-center">

<button
type="button"
class="btn btn-outline-success"
onclick="tambah(<?= $d['id_menu']; ?>)">
+
</button>

</div>

<input
type="hidden"
name="nama[<?= $d['id_menu']; ?>]"
value="<?= $d['nama_menu']; ?>">

<input
type="hidden"
name="harga[<?= $d['id_menu']; ?>]"
value="<?= $d['harga']; ?>">

</div>

</div>

</div>

<?php } ?>

</div>
</div>

<button
name="tambah_semua"
class="btn btn-danger w-100 mt-4">

Tambah ke Keranjang

</button>

</form>

</div>

<footer>
    © 2026 - Andre Radhitya | Rafif Rizki Naufal | Yuda Wahyu
</footer>

</div>

<script>

document.getElementById('cariMenu')
.addEventListener('keyup', function(){

let keyword =
this.value.toLowerCase();

document.querySelectorAll('.item-menu')
.forEach(function(item){

let text =
item.innerText.toLowerCase();

item.style.display =
text.includes(keyword)
? 'block'
: 'none';

});

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>

function tambah(id){

let qty =
document.getElementById('qty'+id);

qty.value =
parseInt(qty.value) + 1;

}

function kurang(id){

let qty =
document.getElementById('qty'+id);

if(parseInt(qty.value) > 0){

qty.value =
parseInt(qty.value) - 1;

}

}

</script>

</body>
</html>