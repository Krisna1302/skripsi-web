<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_pengajuan'];
    $status = $_POST['status'];
    $tanggal = date('Y-m-d H:i:s');

    $update = mysqli_query($conn, "UPDATE pengajuan SET status = '$status', tanggal = '$tanggal' WHERE id = '$id'");

    if ($update) {
        $_SESSION['success'] = "Status berhasil diperbarui.";
    } else {
        $_SESSION['success'] = "Gagal memperbarui status.";
    }
    header("Location: pengajuan.php");
    exit;
}
?>
