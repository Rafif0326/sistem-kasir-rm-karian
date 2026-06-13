<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login'])) {
    header("location:../auth/login.php");
    exit;
}

$pesan = "";

// HAPUS ITEM
if (isset($_GET['hapus'])) {
    unset($_SESSION['keranjang'][$_GET['hapus']]);
}

// UPDATE QTY
if (isset($_POST['update'])) {

    foreach ($_POST['qty'] as $key => $val) {

        if ($val <= 0) {
            unset($_SESSION['keranjang'][$key]);
        } else {
            $_SESSION['keranjang'][$key]['qty'] = $val;
        }
    }
}

// BAYAR
if (isset($_POST['bayar'])) {

    if (empty($_SESSION['keranjang'])) {

        $pesan = "
        <div class='alert alert-danger'>
            Keranjang masih kosong!
        </div>";

    } else {

        $bayar = $_POST['uang'];
        $total = 0;

        foreach ($_SESSION['keranjang'] as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        if ($bayar < $total) {

            $pesan = "
            <div class='alert alert-danger'>
                Uang pembayaran kurang!
            </div>";

        } else {

            $kembalian = $bayar - $total;

            // SIMPAN TRANSAKSI
            $simpan = mysqli_query($conn,"
                INSERT INTO transaksi
                (
                    tanggal,
                    total,
                    bayar,
                    kembalian,
                    status_pesanan
                )
                VALUES
                (
                    NOW(),
                    '$total',
                    '$bayar',
                    '$kembalian',
                    'Menunggu'
                )
            ");

            if(!$simpan){
                die(mysqli_error($conn));
            }

            // AMBIL ID TRANSAKSI BARU
            $id = mysqli_insert_id($conn);

            // BUAT NOMOR PESANAN
            $nomorPesanan = "PSN-" . str_pad(
                $id,
                3,
                "0",
                STR_PAD_LEFT
            );

            // UPDATE NOMOR PESANAN
            mysqli_query($conn,"
                UPDATE transaksi
                SET nomor_pesanan='$nomorPesanan'
                WHERE id_transaksi='$id'
            ") or die(mysqli_error($conn));

            // SIMPAN DETAIL TRANSAKSI
            foreach ($_SESSION['keranjang'] as $item) {

                $subtotal =
                $item['harga'] * $item['qty'];

                mysqli_query($conn,"
                    INSERT INTO detail_transaksi
                    VALUES(
                        NULL,
                        '$id',
                        '".$item['nama']."',
                        '".$item['harga']."',
                        '".$item['qty']."',
                        '$subtotal'
                    )
                ") or die(mysqli_error($conn));

            }

            unset($_SESSION['keranjang']);

            echo "
            <script>
                window.location='../transaksi/struk.php?id=$id';
            </script>
            ";
            exit;

        }

    }

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Keranjang</title>

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

.table th{
background:black;
color:white;
}

.card{
border:none;
border-radius:15px;
}

</style>

</head>

<body>

<div class="wrapper">

<nav class="navbar px-3" style="background:black;">

<span class="text-danger fw-bold fs-5">
Keranjang Belanja
</span>

<a href="tampil.php"
class="btn btn-danger btn-sm">
Kembali
</a>

</nav>

<div class="container mt-4 content">

<?= $pesan ?>

<?php

$total = 0;
$totalItem = 0;

if(!empty($_SESSION['keranjang'])){
    foreach($_SESSION['keranjang'] as $item){
        $totalItem += $item['qty'];
    }
}
?>

<div class="card shadow mb-3">

<div class="card-body">

<h5 class="mb-0">
Jumlah Item :
<span class="text-danger">
<?= $totalItem ?>
</span>
</h5>

</div>

</div>

<form method="POST">

<table class="table table-bordered table-striped">

<tr>
<th>Menu</th>
<th width="120">Qty</th>
<th>Subtotal</th>
<th width="100">Aksi</th>
</tr>

<?php

if (!empty($_SESSION['keranjang'])) {

foreach ($_SESSION['keranjang'] as $key => $item) {

$subtotal =
$item['harga'] * $item['qty'];

$total += $subtotal;

?>

<tr>

<td>
<?= $item['nama']; ?>
</td>

<td>

<input
type="number"
name="qty[<?= $key ?>]"
value="<?= $item['qty'] ?>"
min="1"
class="form-control text-center">

</td>

<td>
Rp <?= number_format($subtotal); ?>
</td>

<td>

<a href="?hapus=<?= $key ?>"
class="btn btn-danger btn-sm">
Hapus
</a>

</td>

</tr>

<?php
}
}
?>

</table>

<button
name="update"
class="btn btn-warning">

Update Qty

</button>

</form>

<hr>

<div class="card shadow">

<div class="card-body">

<h3 class="text-danger fw-bold">
Total : Rp <?= number_format($total); ?>
</h3>

<form method="POST">

<label class="mb-2 fw-bold">
Uang Pembayaran
</label>

<input
type="number"
name="uang"
class="form-control mb-3"
required>

<button
name="bayar"
class="btn btn-danger w-100">

Bayar & Cetak Struk

</button>

</form>

</div>

</div>

</div>

<footer>
© 2026 - Andre Radhitya | Rafif Rizki Naufal | Yuda Wahyu
</footer>

</div>

</body>
</html>