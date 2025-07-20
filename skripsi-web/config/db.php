<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'skripsi_db';

// Buat koneksi
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>
