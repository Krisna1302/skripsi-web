<?php
session_start();
include "../../config/db.php";

$nama       = $_POST['nama'];
$nim        = $_POST['nim'];
$judul      = $_POST['judul'];
$bidang     = $_POST['bidang'];
$pembimbing = $_POST['pembimbing'];

$filename   = $_FILES['file']['name'];
$tmp_name   = $_FILES['file']['tmp_name'];
$target_dir = "../../uploads/";

if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$target_file = $target_dir . basename($filename);
move_uploaded_file($tmp_name, $target_file);

$query = "INSERT INTO pengajuan (nama, nim, judul, bidang, pembimbing, file) 
          VALUES ('$nama', '$nim', '$judul', '$bidang', '$pembimbing', '$filename')";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Pengajuan berhasil!'); window.location='status.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
