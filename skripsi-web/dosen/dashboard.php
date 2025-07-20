<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'dosen') {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Dosen</title>
  <link rel="stylesheet" href="../assets/CSS/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"/>
  <style>
    body {
      display: flex;
      min-height: 100vh;
      margin: 0;
      background-color: #1e1e2f;
      color: #f1f1f1;
      font-family: 'Segoe UI', sans-serif;
      overflow-x: hidden;
    }
    .sidebar {
      width: 240px;
      background-color: #15161d;
      padding-top: 20px;
      flex-shrink: 0;
    }
    .sidebar h5 {
      text-align: center;
      color: #ffffff;
      margin-bottom: 20px;
    }
    .sidebar a {
      color: #bbb;
      display: block;
      padding: 12px 20px;
      text-decoration: none;
      transition: background 0.2s ease;
    }
    .sidebar a:hover,
    .sidebar .active {
      background-color: #2a2b3d;
      color: #fff;
    }
    .content {
      flex-grow: 1;
      padding: 40px;
    }
    .card {
      background-color: #2a2b3d;
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      color: #f1f1f1;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h5>Dosen Panel</h5>
  <a href="dashboard.php" class="active">Dashboard</a>
  <a href="../logout.php" onclick="return confirm('Logout sekarang?')">Logout</a>
</div>

<!-- Main Content -->
<div class="content">
  <h2 data-aos="fade-right">Selamat datang, <?php echo $_SESSION['username']; ?>!</h2>
  <p data-aos="fade-left">Berikut adalah skripsi yang diajukan oleh mahasiswa bimbingan Anda.</p>

  <div class="card p-4 mt-4" data-aos="zoom-in">
    <h4>Daftar Pengajuan Mahasiswa</h4>
    <p>Modul review dan acc pengajuan akan ditambahkan di tahap selanjutnya.</p>
  </div>
</div>

<script src="../assets/JS/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>

</body>
</html>
