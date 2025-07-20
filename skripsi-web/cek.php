<?php
session_start();
include 'config/db.php';

// Ambil input
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = $_POST['password'];

// Cek di tabel admin
$query = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
if (mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);
    if (password_verify($password, $data['password'])) {
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = 'admin';
        header("Location: admin/dashboard.php");
        exit;
    }
}

// Cek di tabel mahasiswa
$query = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE username = '$username'");
if (mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);
    if (password_verify($password, $data['password'])) {
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = 'mahasiswa';
        header("Location: mahasiswa/dashboard.php");
        exit;
    }
}

// Cek di tabel dosen
$query = mysqli_query($conn, "SELECT * FROM dosen WHERE username = '$username'");
if (mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);
    if (password_verify($password, $data['password'])) {
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = 'dosen';
        header("Location: dosen/dashboard.php");
        exit;
    }
}

// Jika login gagal
echo "<script>
    alert('Login gagal! Username atau password salah.');
    window.location.href = 'index.php';
</script>";
?>
