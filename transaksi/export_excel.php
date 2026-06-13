<?php
include '../config/koneksi.php';

// header excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Penjualan.xls");

?>

<h3>Laporan Penjualan Rumah Makan Karian</h3>

<table border="1">
<tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Total</th>
    <th>Bayar</th>
    <th>Kembalian</th>
</tr>

<?php
$no = 1;
$data = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY id_transaksi DESC");

while ($d = mysqli_fetch_array($data)) {
?>

<tr>
    <td><?= $no++; ?></td>
    <td><?= $d['tanggal']; ?></td>
    <td><?= $d['total']; ?></td>
    <td><?= $d['bayar']; ?></td>
    <td><?= $d['kembalian']; ?></td>
</tr>

<?php } ?>

</table>