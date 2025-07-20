<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: ../index.php");
    exit;
}

include '../config/db.php';

$username = $_SESSION['username'];
$mhs = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE username = '$username'");
$data_mhs = mysqli_fetch_assoc($mhs);

// Ambil history pengajuan
$nim = $data_mhs['nim'];
$pengajuan = mysqli_query($conn, "SELECT * FROM pengajuan WHERE nim = '$nim' ORDER BY tanggal DESC");

// Quotes acak
$quotes = [
  "“Jangan menunggu waktu yang sempurna, karena waktu tidak akan pernah sempurna.”",
  "“Skripsi bukan tentang siapa yang tercepat, tapi siapa yang tetap bertahan.”",
  "“Setiap baris kode adalah satu langkah menuju wisuda.”",
  "“Gagal dalam skripsi itu biasa, yang penting jangan menyerah!”",
];
$random_quote = $quotes[array_rand($quotes)];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Mahasiswa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/CSS/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"/>
  <style>
    body {
      background-color: #1e1e2f;
      color: #f1f1f1;
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

    .collapse a {
      padding-left: 35px;
    }

    .sidebar a.dropdown-toggle::after {
      content: '';
    }

    .main {
      margin-left: 220px;
      padding: 40px 20px;
      min-height: 100vh;
    }

    .card {
      background-color: #2a2b3d;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      color: #f1f1f1 !important;
    }

    .profile {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 30px;
    }

    .profile img {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #4e9af1;
    }

    .history-box {
      background-color: #1e1e2f;
      padding: 15px 20px;
      margin-bottom: 10px;
      border-left: 4px solid #4e9af1;
      border-radius: 8px;
      color: #f1f1f1 !important;
    }

    .history-box:hover {
      background-color: #2d2e42;
    }

    .status-menunggu { color: #ffc107; font-weight: bold; }
    .status-diterima { color: #4caf50; font-weight: bold; }
    .status-ditolak { color: #f44336; font-weight: bold; }

    .quote {
      background-color: #343a40;
      border-left: 4px solid #4e9af1;
      padding: 15px 20px;
      border-radius: 8px;
      font-style: italic;
      color: #eee;
      margin-bottom: 25px;
    }

    @media (max-width: 768px) {
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
      }

      .main {
        margin-left: 0;
        padding: 20px;
      }
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h5>Mahasiswa</h5>
  <hr class="bg-secondary mx-3">
  <a href="dashboard.php" class="active">Dashboard</a>
  <a class="dropdown-toggle" data-bs-toggle="collapse" href="#menuPengajuan" role="button" aria-expanded="true">
    Pengajuan
  </a>
  <div class="collapse show ms-1" id="menuPengajuan">
    <a href="pengajuan/ajukan.php">Ajukan</a>
    <a href="pengajuan/status.php">Status</a>
  </div>
  <a href="../logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
</div>

<!-- Main Content -->
<div class="main" data-aos="fade-up">
  <h3 class="mb-3">Selamat datang, <?= htmlspecialchars($data_mhs['nama']) ?> 👋</h3>
  <div class="quote"><?= $random_quote ?></div>

  <div class="card mb-4">
    <div class="profile">
      <img src="../assets/img/default.png" alt="Foto Profil">
      <div>
        <h4 class="mb-1"><?= htmlspecialchars($data_mhs['nama']) ?></h4>
        <p class="mb-0">NIM: <?= htmlspecialchars($data_mhs['nim']) ?></p>
        <p class="mb-0">Prodi: <?= htmlspecialchars($data_mhs['prodi']) ?></p>
      </div>
    </div>
  </div>

  <div class="card">
    <h5 class="mb-3">Riwayat Pengajuan</h5>
    <?php if (mysqli_num_rows($pengajuan) == 0): ?>
      <p class="text-warning">Belum ada pengajuan judul skripsi.</p>
    <?php else: ?>
      <?php while ($p = mysqli_fetch_assoc($pengajuan)): ?>
        <div class="history-box">
          <strong><?= htmlspecialchars($p['judul']) ?></strong><br>
          Status:
          <?php
            $s = strtolower($p['status']);
            if ($s === 'menunggu') echo '<span class="status-menunggu">Menunggu</span>';
            elseif ($s === 'diterima') echo '<span class="status-diterima">Diterima</span>';
            elseif ($s === 'ditolak') echo '<span class="status-ditolak">Ditolak</span>';
            else echo htmlspecialchars($s);
          ?>
          <div style="font-size: 13px; color: #aaa;">Dikirim: <?= date("d M Y, H:i", strtotime($p['tanggal'])) ?></div>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</div>

<?php include '../partials/footer.php'; ?>
<script src="../JS/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
