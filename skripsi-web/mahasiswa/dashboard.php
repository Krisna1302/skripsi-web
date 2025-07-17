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
  <title>Dashboard Mahasiswa</title>
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
      margin-bottom: 20px;
      color: #ffffff;
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

    .dropdown-menu-custom {
      padding-left: 20px;
      display: none;
    }

    .dropdown-menu-custom a {
      font-size: 0.95rem;
      padding-left: 35px;
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
      transition: transform 0.3s;
    }

    .card:hover {
      transform: translateY(-4px);
    }

    .section-title {
      border-bottom: 1px solid #444;
      padding-bottom: 8px;
      margin-bottom: 25px;
    }
  </style>
</head>
<body class="d-flex flex-column" style="min-height: 100vh;">
  <div class="d-flex flex-grow-1">
<!-- Sidebar -->
<div class="sidebar">
  <h5>Mahasiswa</h5>
  <a href="dashboard.php" class="active">Dashboard</a>
  
  <a href="#" onclick="toggleDropdown()">Pengajuan ▼</a>
  <div id="pengajuanSubmenu" class="dropdown-menu-custom">
    <a href="pengajuan/ajukan.php">Ajukan Judul</a>
    <a href="pengajuan/status.php">Lihat Status</a>
  </div>

  <a href="../logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
</div>

<!-- Main Content -->
<div class="content">
  <h2 class="section-title" data-aos="fade-right">Selamat datang, <?php echo $_SESSION['username']; ?>!</h2>

  <div class="row" data-aos="fade-up">
    <div class="col-md-12">
      <div class="card p-4 mb-4">
        <h4>Status Pengajuan Skripsi Terbaru</h4>
        <?php
        include "../config/db.php";
        $username = $_SESSION['username'];
        $query = mysqli_query($conn, "SELECT * FROM pengajuan WHERE nim='$username' ORDER BY tanggal DESC LIMIT 1");
        if (mysqli_num_rows($query) > 0) {
          $data = mysqli_fetch_assoc($query);
          echo "<p><strong>Judul:</strong> {$data['judul']}</p>";
          echo "<p><strong>Status:</strong> {$data['status']}</p>";
          echo "<p><strong>Tanggal:</strong> {$data['tanggal']}</p>";
          echo "<a href='pengajuan/status.php' class='btn btn-outline-light btn-sm'>Lihat Detail</a>";
        } else {
          echo "<p>Anda belum melakukan pengajuan skripsi.</p>";
          echo "<a href='pengajuan/ajukan.php' class='btn btn-primary btn-sm'>Ajukan Skripsi Sekarang</a>";
        }
        ?>
      </div>
    </div>
  </div>
</div>
</div>
<script src="../assets/JS/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();

  function toggleDropdown() {
    const menu = document.getElementById("pengajuanSubmenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
  }
</script>
<?php include '../partials/footer.php'; ?>

</body>
</html>
