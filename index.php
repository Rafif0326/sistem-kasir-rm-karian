<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['login'])) {
    header("location:auth/login.php");
    exit;
}

// Statistik
$totalTransaksi = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi")
);

$totalPendapatan = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT SUM(total) as total FROM transaksi")
);

$penjualanHari = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT SUM(total) as total
        FROM transaksi
        WHERE DATE(tanggal)=CURDATE()
    ")
);

$jumlahMenu = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT COUNT(*) as total
        FROM menu
    ")
);

$pesananMenunggu = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT COUNT(*) as total
        FROM transaksi
        WHERE status_pesanan='Menunggu'
    ")
);

$pesananDiproses = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT COUNT(*) as total
        FROM transaksi
        WHERE status_pesanan='Diproses'
    ")
);

$pesananDimasak = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT COUNT(*) as total
        FROM transaksi
        WHERE status_pesanan='Dimasak'
    ")
);

$pesananSelesai = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT COUNT(*) as total
        FROM transaksi
        WHERE status_pesanan='Selesai'
    ")
);

// Data Grafik
$grafik = mysqli_query($conn,"
    SELECT
    DATE(tanggal) as tgl,
    SUM(total) as total
    FROM transaksi
    GROUP BY DATE(tanggal)
    ORDER BY DATE(tanggal) ASC
");

$label = [];
$data = [];

while($g = mysqli_fetch_assoc($grafik)){
    $label[] = date('d/m/Y', strtotime($g['tgl']));
    $data[] = $g['total'];
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Dashboard Kasir Rumah Makan Karian</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        .logo{
            border-radius:50%;
        }

        .dashboard-title{
            font-weight:bold;
        }

       .menu-btn{
    height:90px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
    border-radius:18px;
    font-size:22px;
    border:none;
    transition:.3s;
}

.menu-btn:hover{
    transform:translateY(-5px);
}

        .card{
            border:none;
            border-radius:15px;
            transition:.3s;
        }

        .card:hover{
            transform:translateY(-4px);
        }

        .stat-card{
            min-height:120px;
        }

        footer{
            background:black;
            color:white;
            text-align:center;
            padding:12px;
        }

        canvas{
            max-height:350px;
        }

    </style>

</head>

<body>

<div class="wrapper">

<!-- NAVBAR -->

<nav class="navbar px-3">

    <img src="assets/logo.jpeg"
         width="50"
         class="logo">

    <div class="mx-auto text-center">

    <div class="text-danger fw-bold fs-3">
        Kasir Rumah Makan Karian
    </div>

    <small class="text-white">
        Login sebagai :
        <?= strtoupper($_SESSION['username']); ?>
        (<?= strtoupper($_SESSION['role']); ?>)
    </small>

</div>

    <a href="auth/logout.php"
       class="btn btn-danger">
        Logout
    </a>

</nav>

<!-- CONTENT -->

<div class="container mt-4 content">

    <!-- MENU UTAMA -->

<!-- MENU UTAMA -->

<div class="row g-3 justify-content-center mb-5">

    <div class="col-lg-3 col-md-6">
        <a href="menu/tampil.php"
           class="btn btn-danger menu-btn w-100 shadow">
            🛒 Masuk Kasir
        </a>
    </div>

    <?php if($_SESSION['role'] == 'admin'){ ?>

    <div class="col-lg-3 col-md-6">
        <a href="admin/menu.php"
           class="btn btn-secondary menu-btn w-100 shadow">
            🍽 Kelola Menu
        </a>
    </div>

    <div class="col-lg-3 col-md-6">
        <a href="transaksi/pesanan.php"
           class="btn btn-warning menu-btn w-100 shadow">
            📋 Manajemen Pesanan
        </a>
    </div>

    <div class="col-lg-3 col-md-6">
        <a href="transaksi/laporan.php"
           class="btn btn-dark menu-btn w-100 shadow">
            📊 Lihat Laporan
        </a>
    </div>

    <?php } ?>

</div>
    <!-- JUDUL -->

    <h2 class="text-center dashboard-title mb-4">
        Dashboard Kasir
    </h2>

    <div class="text-center mb-4">
    <h5 id="jam"></h5>
    </div>
    <!-- STATISTIK -->

    <div class="row">


        <div class="col-md-3 mb-3">

            <div class="card stat-card bg-dark text-white shadow">

                <div class="card-body text-center">

                    <h6>Total Transaksi</h6>

                    <h2>
                        <?= $totalTransaksi['total']; ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card stat-card bg-danger text-white shadow">

                <div class="card-body text-center">

                    <h6>Total Pendapatan</h6>

                    <h5>
                        Rp <?= number_format($totalPendapatan['total'] ?? 0); ?>
                    </h5>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card stat-card bg-secondary text-white shadow">

                <div class="card-body text-center">

                    <h6>Penjualan Hari Ini</h6>

                    <h5>
                        Rp <?= number_format($penjualanHari['total'] ?? 0); ?>
                    </h5>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card stat-card bg-success text-white shadow">

                <div class="card-body text-center">

                    <h6>Jumlah Menu</h6>

                    <h2>
                        <?= $jumlahMenu['total']; ?>
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-2">

<div class="col-md-3 mb-3">
<div class="card shadow border-start border-warning border-4">
<div class="card-body text-center">
<h6>Menunggu</h6>
<h2><?= $pesananMenunggu['total']; ?></h2>
</div>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card shadow border-start border-primary border-4">
<div class="card-body text-center">
<h6>Diproses</h6>
<h2><?= $pesananDiproses['total']; ?></h2>
</div>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card shadow border-start border-info border-4">
<div class="card-body text-center">
<h6>Dimasak</h6>
<h2><?= $pesananDimasak['total']; ?></h2>
</div>
</div>
</div>

<div class="col-md-3 mb-3">
<div class="card shadow border-start border-success border-4">
<div class="card-body text-center">
<h6>Selesai</h6>
<h2><?= $pesananSelesai['total']; ?></h2>
</div>
</div>
</div>

</div>

    <!-- GRAFIK -->

    <div class="card shadow mt-3 mb-4">

        <div class="card-body">

            <h4 class="mb-3">
                Grafik Penjualan
            </h4>

            <canvas id="grafikPenjualan"></canvas>

        </div>

    </div>

</div>

<!-- FOOTER -->

<footer>
    © 2026 - Andre Radhitya | Rafif Rizki Naufal | Yuda Wahyu
</footer>

</div>

<script>

const ctx = document.getElementById('grafikPenjualan');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: <?= json_encode($label); ?>,

        datasets: [{

            label: 'Penjualan (Rp)',

            data: <?= json_encode($data); ?>,

            backgroundColor: '#dc3545',

            borderColor: '#000000',

            borderWidth: 1

        }]
    },

    options: {

        responsive: true,

        plugins: {

            legend: {
                display: true
            }

        },

        scales: {

            y: {
                beginAtZero: true
            }

        }

    }

});

</script>
<script>

function updateJam(){

    const sekarang = new Date();

    document.getElementById("jam").innerHTML =
    sekarang.toLocaleString('id-ID');

}

setInterval(updateJam,1000);

updateJam();

</script>

</body>
</html>