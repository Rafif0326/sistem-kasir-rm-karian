<?php

include '../config/koneksi.php';

$id=$_GET['id'];

mysqli_query(
$conn,
"DELETE FROM menu WHERE id_menu='$id'"
);

header("location:menu.php");