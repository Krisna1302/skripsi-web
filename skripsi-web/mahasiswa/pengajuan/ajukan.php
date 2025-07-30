<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: ../../index.php");
    exit;
}

include '../../config/db.php';

$username = $_SESSION['username'];
$mhs = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE username = '$username'");
$data_mhs = mysqli_fetch_assoc($mhs);
$prodi = $data_mhs['prodi'];

// Ambil nama & nidn dosen sesuai prodi
$dosen_query = mysqli_query($conn, "SELECT nama, nidn FROM dosen WHERE kaprodi = '$prodi'");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Ajukan Skripsi</title>
  <link rel="stylesheet" href="../../assets/CSS/bootstrap.min.css">
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

    .container {
      max-width: 700px;
    }

    .card {
      background-color: #2a2b3d;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    }

    .form-label {
      font-weight: 500;
      margin-bottom: 5px;
      color: #f1f1f1;
    }

    .form-control {
      background-color: #1e1e2f;
      color: #ffffff;
      border: 1px solid #555;
      font-size: 0.95rem;
      font-weight: 400;
    }

    .form-control::placeholder {
      color: #aaa;
    }

    .form-control:focus {
      background-color: #1e1e2f;
      color: #fff;
      border-color: #4e9af1;
      box-shadow: none;
    }

    .btn-submit {
      background-color: #4e9af1;
      border: none;
    }

    .btn-submit:hover {
      background-color: #3b83d6;
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
    <a href="ajukan.php" class="active">Ajukan</a>
    <a href="status.php" >Status</a>
</div>
  <a href="../../logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
</div>

<!-- Main Content -->
<div class="main">
  <div class="container" data-aos="fade-up">
    <h2 class="text-center mb-4">Form Pengajuan Judul Skripsi</h2>
    <div class="card">
      <form action="proses_pengajuan.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data_mhs['nama']) ?>" readonly>
        </div>
        <div class="mb-3">
          <label class="form-label">NIM</label>
          <input type="text" name="nim" class="form-control" value="<?= htmlspecialchars($data_mhs['nim']) ?>" readonly>
        </div>
        <div class="mb-3">
          <label class="form-label">Judul Skripsi</label>
          <textarea name="judul" class="form-control" placeholder="Masukkan judul skripsi Anda" required></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" class="form-control" placeholder="Tulis deskripsi singkat mengenai skripsi Anda" rows="3" required></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Bidang</label>
          <input type="text" name="bidang" class="form-control" value="<?= htmlspecialchars($data_mhs['prodi']) ?>" readonly>
        </div>
        <div class="mb-3">
          <label class="form-label">Dosen Pembimbing</label>
          <select name="pembimbing" class="form-control" id="selectDosen" onchange="updateNidn(this)" required>
            <option value="" disabled selected>Pilih dosen</option>
            <?php while ($d = mysqli_fetch_assoc($dosen_query)) : ?>
              <option value="<?= htmlspecialchars($d['nama']) ?>" data-nidn="<?= htmlspecialchars($d['nidn']) ?>">
                <?= htmlspecialchars($d['nama']) ?>
              </option>
            <?php endwhile; ?>
          </select>
          <input type="hidden" name="nidn" id="nidnField">
        </div>
        <div class="mb-3">
          <label class="form-label">Upload Proposal (PDF)</label>
          <input type="file" name="file" class="form-control" accept=".pdf,.txt" required>
        </div>
        <button type="submit" class="btn btn-submit w-100">Ajukan Skripsi</button>
      </form>
    </div>
  </div>
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
<script>
  function updateNidn(select) {
    const selected = select.options[select.selectedIndex];
    const nidn = selected.getAttribute('data-nidn');
    document.getElementById('nidnField').value = nidn;
  }
</script>
</body>
</html>
