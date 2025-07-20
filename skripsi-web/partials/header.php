<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Sistem Skripsi Mahasiswa</title>
  <link rel="stylesheet" href="../assets/CSS/bootstrap.min.css">
  <style>
    body {
      background-color: #1e1e2f;
      color: #fff;
      font-family: Arial, sans-serif;
    }

    .sidebar {
      width: 220px;
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      background-color: #15161d;
      padding-top: 20px;
    }

    .sidebar h5 {
      text-align: center;
      color: #ccc;
      margin-bottom: 15px;
    }

    .sidebar a {
      display: block;
      color: #ccc;
      padding: 12px 20px;
      text-decoration: none;
      transition: background 0.2s ease;
    }

    .sidebar a:hover,
    .sidebar .active {
      background-color: #343a40;
      color: #fff;
    }

    .main {
      margin-left: 220px;
      padding: 30px;
      min-height: 100vh;
    }

    .collapse a {
      padding-left: 35px;
    }

    .sidebar a.dropdown-toggle::after {
      content: '';
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h5>Mahasiswa</h5>
  <hr class="bg-secondary mx-3">

  <a href="../mahasiswa/dashboard.php">Dashboard</a>

  <!-- Dropdown menu pengajuan -->
  <a class="dropdown-toggle" data-bs-toggle="collapse" href="#menuPengajuan" role="button" aria-expanded="false" aria-controls="menuPengajuan">
    Pengajuan
  </a>
  <div class="collapse ms-1" id="menuPengajuan">
    <a href="../mahasiswa/pengajuan/ajukan.php">Ajukan</a>
    <a href="../mahasiswa/pengajuan/status.php">Status</a>
  </div>

  <a href="../logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
</div>

<!-- Main Content -->
<div class="main">
