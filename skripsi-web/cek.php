<?php
session_start();
include 'config/db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query_admin = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
$query_dosen = mysqli_query($conn, "SELECT * FROM dosen WHERE username = '$username'");
$query_mahasiswa = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE username = '$username'");

if ($data = mysqli_fetch_assoc($query_admin)) {
    if (password_verify($password, $data['password'])) {
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = 'admin';
        header("Location: admin/dashboard.php");
        exit;
    }
}
if ($data = mysqli_fetch_assoc($query_dosen)) {
    if (password_verify($password, $data['password'])) {
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = 'dosen';
        header("Location: dosen/dashboard.php");
        exit;
    }
}
if ($data = mysqli_fetch_assoc($query_mahasiswa)) {
    if (password_verify($password, $data['password'])) {
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = 'mahasiswa';
        header("Location: mahasiswa/dashboard.php");
        exit;
    }
}

// Jika gagal
echo "<script>alert('Login gagal! Username atau password salah');window.location='index.php';</script>";
?>
