<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "skripsi_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
