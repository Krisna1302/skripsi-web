<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'dosen') {
    header("Location: ../index.php");
    exit;
}

include '../config/db.php';
$username = $_SESSION['username'];

$dosen = mysqli_query($conn, "SELECT * FROM dosen WHERE username = '$username'");
$data_dosen = mysqli_fetch_assoc($dosen);
$kaprodi = $data_dosen['kaprodi'];

// Ambil data pengajuan dengan status selain "Menunggu"
$riwayat = mysqli_query($conn, "SELECT * FROM pengajuan WHERE pembimbing IN (
    SELECT nama FROM dosen WHERE kaprodi = '$kaprodi'
) AND status != 'Menunggu' ORDER BY tanggal DESC");

// Hitung notifikasi pengajuan menunggu
$notif = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengajuan 
                              WHERE pembimbing IN (
                                SELECT nama FROM dosen WHERE kaprodi = '$kaprodi'
                              ) AND status = 'Menunggu'");
$notif_data = mysqli_fetch_assoc($notif);
$jumlah_menunggu = $notif_data['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Pengajuan Skripsi</title>
  <link rel="stylesheet" href="../assets/CSS/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"/>
  <style>
    body {
      background-color: #1e1e2f;
      color: #f1f1f1 !important;
      font-family: 'Segoe UI', sans-serif;
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
      color: #ccc !important;
      margin-bottom: 15px;
    }
    .sidebar a {
      display: block;
      color: #ccc !important;
      padding: 12px 20px;
      text-decoration: none;
      transition: background 0.2s ease;
    }
    .sidebar a:hover,
    .sidebar .active {
      background-color: #343a40;
      color: #fff !important;
    }
    .dropdown-sub {
      background-color: #1c1d26;
    }
    .dropdown-sub a {
      padding-left: 40px;
      font-size: 0.95rem;
    }
    .slide-menu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.4s ease;
    }
    .slide-menu.open {
      max-height: 200px;
    }
    #dropdownToggle {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    #arrowIcon {
      font-size: 1.5rem;
      transition: transform 0.3s ease;
      margin-left: 10px;
    }
    .arrow.rotate {
      transform: rotate(180deg);
    }
    .main {
      margin-left: 220px;
      padding: 40px 20px;
      min-height: 100vh;
    }
    h2 {
      color: #f1f1f1 !important;
      margin-bottom: 30px;
    }
    .table {
      background-color: #2a2b3d;
      color: #f1f1f1 !important;
      border-radius: 8px;
    }
    .table th, .table td {
      background-color: #2a2b3d !important;
      color: #f1f1f1 !important;
      border-color: #444;
      padding: 12px;
      vertical-align: middle;
    }
    .table thead {
      background-color: #1f1f2e;
    }
    .status-badge {
      font-weight: bold;
    }
    .status-diterima {
      color: #81f781 !important;
    }
    .status-ditolak {
      color: #f18b8b !important;
    }
    .empty-message {
      text-align: center;
      padding: 40px;
      font-size: 1.1rem;
      color: #aaa;
      background-color: #2a2b3d;
      border-radius: 8px;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h5>Dosen</h5>
  <hr class="bg-secondary mx-3">
  
  <a href="dashboard.php">Dashboard</a>
  <a href="javascript:void(0)" onclick="toggleDropdown()" id="dropdownToggle">
    Data Pengajuan
    <?php if ($jumlah_menunggu > 0): ?>
      <span class="badge bg-danger ms-2"><?= $jumlah_menunggu ?></span>
    <?php endif; ?>
    <span class="arrow" id="arrowIcon">▾</span>
  </a>
  <div id="dropdownMenu" class="dropdown-sub slide-menu open">
    <a href="pengajuan.php">Pengajuan Skripsi</a>
    <a href="history.php" class="active">Riwayat Pengajuan</a>
  </div>
  <a href="../logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
</div>

<!-- Main Content -->
<div class="main">
  <h2 data-aos="fade-down">Riwayat Pengajuan Judul Skripsi</h2>

  <?php if (mysqli_num_rows($riwayat) > 0): ?>
  <div class="table-responsive" data-aos="fade-up">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Nama</th>
          <th>NIM</th>
          <th>Judul</th>
          <th>Deskripsi</th>
          <th>Bidang</th>
          <th>Pembimbing</th>
          <th>Status</th>
          <th>Proposal</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($riwayat)): ?>
        <tr>
          <td><?= htmlspecialchars($row['nama']) ?></td>
          <td><?= htmlspecialchars($row['nim']) ?></td>
          <td><?= htmlspecialchars($row['judul']) ?></td>
          <td><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></td>
          <td><?= htmlspecialchars($row['bidang']) ?></td>
          <td><?= htmlspecialchars($row['pembimbing']) ?></td>
          <td>
            <span class="status-badge 
              <?= $row['status'] == 'Diterima' ? 'status-diterima' : 'status-ditolak' ?>">
              <?= htmlspecialchars($row['status']) ?>
            </span>
          </td>
          <td>
            <a href="../uploads/<?= htmlspecialchars($row['file']) ?>" target="_blank" class="btn btn-sm btn-secondary">Lihat</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
    <div class="empty-message" data-aos="fade-up">
      Belum ada riwayat pengajuan yang diproses.
    </div>
  <?php endif; ?>
</div>

<script src="../assets/JS/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
  function toggleDropdown() {
    const menu = document.getElementById("dropdownMenu");
    const arrow = document.getElementById("arrowIcon");
    menu.classList.toggle("open");
    arrow.classList.toggle("rotate");
  }
</script>
</body>
</html>
