<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: ../../index.php");
    exit;
}

include '../../config/db.php';

// Ambil data dari form
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$nim = mysqli_real_escape_string($conn, $_POST['nim']);
$judul = mysqli_real_escape_string($conn, $_POST['judul']);
$deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
$bidang = mysqli_real_escape_string($conn, $_POST['bidang']);
$pembimbing = mysqli_real_escape_string($conn, $_POST['pembimbing']);

// Cek dan proses file upload
$filename = $_FILES['file']['name'];
$tmpname = $_FILES['file']['tmp_name'];
$filesize = $_FILES['file']['size'];
$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
$allowed = ['pdf', 'txt'];

if (!in_array($ext, $allowed)) {
    echo "<script>alert('File harus berupa PDF.'); window.history.back();</script>";
    exit;
}

$newname = uniqid() . '.' . $ext;
$uploadpath = '../../uploads/' . $newname;

if (!move_uploaded_file($tmpname, $uploadpath)) {
    echo "<script>alert('Gagal mengupload file.'); window.history.back();</script>";
    exit;
}

// Simpan ke database
$query = "INSERT INTO pengajuan (nama, nim, judul, deskripsi, bidang, pembimbing, file)
          VALUES ('$nama', '$nim', '$judul', '$deskripsi', '$bidang', '$pembimbing', '$newname')";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Pengajuan berhasil dikirim.'); window.location.href='../dashboard.php';</script>";
} else {
    echo "<script>alert('Gagal menyimpan data ke database.'); window.history.back();</script>";
}
?>
