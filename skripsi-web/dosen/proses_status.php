<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'dosen') {
    header("Location: ../index.php");
    exit;
}

include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pengajuan = $_POST['id_pengajuan'];
    $status = $_POST['status'];
    $komentar = isset($_POST['komentar']) ? mysqli_real_escape_string($conn, $_POST['komentar']) : '';

    // Update status dan komentar di database
    $query = "UPDATE pengajuan SET status = '$status', komentar = '$komentar' WHERE id = $id_pengajuan";
    if (mysqli_query($conn, $query)) {
        header("Location: pengajuan.php");
        exit;
    } else {
        echo "Gagal memperbarui status: " . mysqli_error($conn);
    }
}
?>
