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

// Ambil dosen sesuai prodi
$dosen_query = mysqli_query($conn, "SELECT nama FROM dosen WHERE kaprodi = '$prodi'");
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
  <a href="../dashboard.php">Dashboard</a>
  <a class="dropdown-toggle" data-bs-toggle="collapse" href="#menuPengajuan" role="button" aria-expanded="true" aria-controls="menuPengajuan">
    Pengajuan
  </a>
  <div class="collapse show ms-1" id="menuPengajuan">
    <a href="ajukan.php" class="active">Ajukan</a>
    <a href="status.php">Status</a>
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
          <select name="pembimbing" class="form-control" required>
            <option value="" disabled selected>Pilih dosen</option>
            <?php while ($d = mysqli_fetch_assoc($dosen_query)) : ?>
              <option value="<?= htmlspecialchars($d['nama']) ?>"><?= htmlspecialchars($d['nama']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Upload Proposal (PDF)</label>
          <input type="file" name="file" class="form-control" accept=".pdf" required>
        </div>
        <button type="submit" class="btn btn-submit w-100">Ajukan Skripsi</button>
      </form>
    </div>
  </div>
</div>

<?php include '../../partials/footer.php'; ?>
<script src="../../assets/JS/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
