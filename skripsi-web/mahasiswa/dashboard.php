<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: ../index.php");
    exit;
}

include '../config/db.php';
$username = $_SESSION['username'];

// Ambil data mahasiswa
$query = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE username = '$username'");
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Mahasiswa</title>
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

    .card-profile {
      background-color: #2a2b3d;
      border-radius: 12px;
      padding: 30px;
      display: flex;
      align-items: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.4);
      animation: fadeIn 0.6s ease-in-out;
    }

    .profile-img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 30px;
      border: 3px solid #555;
    }

    .profile-info h4 {
      margin-bottom: 5px;
    }

    .card {
      background-color: #2a2b3d;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.4);
    }

    .list-group-item {
      background-color: transparent;
      border: none;
      font-size: 15px;
    }

    .text-success {
      color: #81f781 !important;
    }

    .text-danger {
      color: #f18b8b !important;
    }

    .text-warning {
      color: #ffc107 !important;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h5>Mahasiswa</h5>
  <hr class="bg-secondary mx-3">
  <a href="dashboard.php" class="active">Dashboard</a>
  <a class="dropdown-toggle" data-bs-toggle="collapse" href="#menuPengajuan" role="button" aria-expanded="false" aria-controls="menuPengajuan">
    Pengajuan
  </a>
  <div class="collapse ms-1" id="menuPengajuan">
    <a href="pengajuan/ajukan.php">Ajukan</a>
    <a href="pengajuan/status.php">Status</a>
  </div>
  <a href="../logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
</div>

<!-- Main Content -->
<div class="main">
  <h2 class="mb-4" data-aos="fade-down">Selamat Datang, <?= htmlspecialchars($data['nama']) ?></h2>

  <div class="card-profile mb-5" data-aos="fade-up">
    <img src="<?= $data['foto'] ? '../uploads/' . $data['foto'] : '../assets/img/default-user.png' ?>" alt="Foto Profil" class="profile-img">
    <div class="profile-info">
      <h4><?= htmlspecialchars($data['nama']) ?></h4>
      <p><strong>NIM:</strong> <?= htmlspecialchars($data['nim']) ?></p>
      <p><strong>Program Studi:</strong> <?= htmlspecialchars($data['prodi']) ?></p>
      <p><strong>Username:</strong> <?= htmlspecialchars($data['username']) ?></p>
    </div>
  </div>

  <h4 class="mb-3" data-aos="fade-right">Riwayat Pengajuan Skripsi</h4>
  <div class="card" data-aos="fade-up">
    <ul class="list-group list-group-flush">
      <?php
        $riwayat = mysqli_query($conn, "SELECT * FROM pengajuan WHERE nim = '{$data['nim']}' ORDER BY tanggal DESC");
        if (mysqli_num_rows($riwayat) == 0) {
          echo '<li class="list-group-item text-warning">Belum ada pengajuan skripsi.</li>';
        } else {
          while ($r = mysqli_fetch_assoc($riwayat)) {
            $tgl = date('d M Y, H:i', strtotime($r['tanggal']));
            $judul = htmlspecialchars($r['judul']);
            $status = strtolower($r['status']);

            if ($status == 'menunggu') {
              echo "<li class='list-group-item text-light'><strong>[$tgl]</strong> Anda mengajukan judul: <em>\"$judul\"</em></li>";
            } elseif ($status == 'diterima') {
              echo "<li class='list-group-item text-success'><strong>[$tgl]</strong> Skripsi <em>\"$judul\"</em> telah <strong>DITERIMA</strong></li>";
            } elseif ($status == 'ditolak') {
              echo "<li class='list-group-item text-danger'><strong>[$tgl]</strong> Skripsi <em>\"$judul\"</em> telah <strong>DITOLAK</strong></li>";
            }
          }
        }
      ?>
    </ul>
  </div>
</div>

<?php include '../partials/footer.php'; ?>
<script src="../assets/JS/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
