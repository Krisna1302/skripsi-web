<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: ../../index.php");
    exit;
}

include '../../config/db.php';
$username = $_SESSION['username'];

// Ambil data mahasiswa
$mhs = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE username = '$username'");
$data_mhs = mysqli_fetch_assoc($mhs);

// Ambil data pengajuan berdasarkan NIM
$nim = $data_mhs['nim'];
$pengajuan = mysqli_query($conn, "SELECT * FROM pengajuan WHERE nim = '$nim' ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Status Pengajuan</title>
  <link rel="stylesheet" href="../../assets/CSS/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"/>
  <style>
    body {
      background-color: #1e1e2f;
      color: #f1f1f1;
      font-family: 'Segoe UI', sans-serif;
    }

    h2, th, td {
      color: #f1f1f1 !important;
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
    }

    .table {
      background-color: #2a2b3d;
      color: #f1f1f1 !important;
      border-collapse: separate;
      border-spacing: 0;
      border-radius: 8px;
      overflow: hidden;
    }

    .table thead {
      background-color: #1f1f2e;
      color: #f1f1f1 !important;
    }

    .table th, .table td {
      border-color: #444;
      background-color: #2a2b3d;
      padding: 12px;
      vertical-align: middle;
      font-size: 15px;
    }

    .table-hover tbody tr:hover td {
      background-color: #383850;
    }

    .badge-status {
      padding: 6px 14px;
      border-radius: 30px;
      font-weight: 500;
      font-size: 0.9rem;
      display: inline-block;
    }

    .status-menunggu {
      background-color: #5c5c3d;
      color: #ffeb3b;
    }

    .status-diterima {
      background-color: #2e5732;
      color: #81f781;
    }

    .status-ditolak {
      background-color: #5a2e2e;
      color: #f18b8b;
    }

    .btn-view {
      background-color: #6c757d;
      color: #fff;
      font-size: 0.85rem;
    }

    .no-data {
      background-color: #343a40;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
      color: #ffc107;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h5>Mahasiswa</h5>
  <hr class="bg-secondary mx-3">
  <a href="../dashboard.php" >Dashboard</a>

  <a href="javascript:void(0)" onclick="toggleDropdown()" id="dropdownToggle">
    Pengajuan
    <span class="arrow" id="arrowIcon">▾</span>
  </a>
  <div id="dropdownMenu" class="dropdown-sub slide-menu">
    <a href="ajukan.php">Ajukan</a>
    <a href="status.php" class="active">Status</a>
</div>
  <a href="../../logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
</div>

<!-- Main Content -->
<div class="main">
  <h2 class="mb-4" data-aos="fade-down">Status Pengajuan Skripsi</h2>

  <?php if (mysqli_num_rows($pengajuan) == 0): ?>
    <div class="no-data" data-aos="fade-up">
      Belum ada pengajuan judul skripsi.
    </div>
  <?php else: ?>
    <div class="card" data-aos="fade-up">
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Judul</th>
              <th>Deskripsi</th>
              <th>Bidang</th>
              <th>Pembimbing</th>
              <th>Tanggal</th>
              <th>File</th>
              <th>Status</th>
              <th>Komentar</th>
            </tr>
          </thead>
          <tbody>
          <?php while ($row = mysqli_fetch_assoc($pengajuan)): ?>
            <tr>
              <td><?= htmlspecialchars($row['judul']) ?></td>
              <td><?= $row['deskripsi'] ? htmlspecialchars($row['deskripsi']) : '<em style="color:#ccc;">Tidak ada deskripsi</em>' ?></td>
              <td><?= htmlspecialchars($row['bidang']) ?></td>
              <td><?= htmlspecialchars($row['pembimbing']) ?></td>
              <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
              <td>
                <a href="lihat_file.php?file=<?= htmlspecialchars($row['file']) ?>" target="_blank" class="btn btn-sm btn-secondary">Lihat</a>
              </td>
              <td>
                <?php
                  $status = strtolower($row['status']);
                  if ($status === 'menunggu') echo '<span class="badge-status status-menunggu">Menunggu</span>';
                  elseif ($status === 'diterima') echo '<span class="badge-status status-diterima">Diterima</span>';
                  elseif ($status === 'ditolak') echo '<span class="badge-status status-ditolak">Ditolak</span>';
                  else echo htmlspecialchars($status);
                ?>
              </td>
              <td><?= $row['komentar'] ? htmlspecialchars($row['komentar']) : '-' ?></td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endif; ?>
</div>

<?php include '../../partials/footer.php'; ?>
<script src="../../assets/JS/bootstrap.bundle.min.js"></script>
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
