<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'dosen') {
    header("Location: ../index.php");
    exit;
}

include '../config/db.php';
$username = $_SESSION['username'];

// Ambil data dosen
$dosen = mysqli_query($conn, "SELECT * FROM dosen WHERE username = '$username'");
$data_dosen = mysqli_fetch_assoc($dosen);

// Path foto
$foto_path = "../assets/img/dosen/" . ($data_dosen['foto'] ?? 'default.png');
if (!file_exists($foto_path)) {
    $foto_path = "../assets/img/dosen/default.png";
}

// Hitung notifikasi pengajuan menunggu (hanya dari prodi yang sesuai)
$kaprodi = $data_dosen['kaprodi'];
$notif_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM pengajuan 
    INNER JOIN mahasiswa ON pengajuan.nim = mahasiswa.nim 
    WHERE pengajuan.status = 'menunggu' 
    AND mahasiswa.prodi = '$kaprodi'");

$notif_data = mysqli_fetch_assoc($notif_query);
$jumlah_menunggu = $notif_data['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Dosen</title>
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

    .card {
      background-color: #2a2b3d;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
      animation: fadeIn 0.8s ease-in-out;
      color: #f1f1f1 !important;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .label {
      font-weight: 600;
      color: #aaa !important;
    }

    .value {
      font-size: 1.1rem;
      color: #f1f1f1 !important;
    }

    .profile-section {
      display: flex;
      align-items: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .profile-section img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid #444;
    }

    .profile-section .info h2 {
      margin-bottom: 10px;
      font-size: 1.8rem;
      color: #f1f1f1 !important;
    }

    .profile-section .info p {
      margin: 4px 0;
    }

    .badge {
      font-size: 0.8rem;
    }

    @media (max-width: 576px) {
      .profile-section {
        flex-direction: column;
        align-items: flex-start;
      }

      .profile-section img {
        margin-bottom: 10px;
      }
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h5>Dosen</h5>
  <hr class="bg-secondary mx-3">
  <a href="dashboard.php" class="active">Dashboard</a>

  <a href="javascript:void(0)" onclick="toggleDropdown()" id="dropdownToggle">
    Data Pengajuan
    <?php if ($jumlah_menunggu > 0): ?>
      <span class="badge bg-danger ms-2"><?= $jumlah_menunggu ?></span>
    <?php endif; ?>
    <span class="arrow" id="arrowIcon">▾</span>
  </a>
  <div id="dropdownMenu" class="dropdown-sub slide-menu">
    <a href="pengajuan.php">Pengajuan Skripsi</a>
    <a href="history.php">Riwayat Pengajuan</a>
  </div>

  <a href="../logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
</div>

<!-- Main Content -->
<div class="main">
  <div class="card" data-aos="fade-down">
    <div class="profile-section">
      <img src="<?= $foto_path ?>" alt="Foto Profil Dosen">
      <div class="info">
        <h2>Selamat datang, <?= htmlspecialchars($data_dosen['nama']) ?>!</h2>
        <p class="label">NIDN:</p>
        <p class="value"><?= htmlspecialchars($data_dosen['nidn']) ?></p>
        <p class="label">Dosen Penasihat:</p>
        <p class="value"><?= htmlspecialchars($data_dosen['kaprodi']) ?></p>
      </div>
    </div>
  </div>
</div>

<?php include '../partials/footer.php'; ?>
<script src="../assets/JS/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();

  function toggleDropdown() {
    const menu = document.getElementById("dropdownMenu");
    const arrow = document.getElementById("arrowIcon");

    if (menu.classList.contains("open")) {
      menu.classList.remove("open");
      arrow.classList.remove("rotate");
    } else {
      menu.classList.add("open");
      arrow.classList.add("rotate");
    }
  }
</script>
</body>
</html>
