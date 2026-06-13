<?php
session_start();
include '../config/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$data = mysqli_query($conn, "
    SELECT * FROM user
    WHERE username='$username'
    AND password='$password'
");

if(mysqli_num_rows($data) > 0){

    $user = mysqli_fetch_assoc($data);

    $_SESSION['login'] = true;
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    header("location:../index.php");
    exit;

}else{

    echo "
    <script>
        alert('Login gagal');
        window.location='login.php';
    </script>
    ";

}
?>