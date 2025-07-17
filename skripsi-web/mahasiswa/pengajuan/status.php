<?php
session_start();
include "../../config/db.php";
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: ../../index.php");
    exit;
}
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
      padding-top: 50px;
    }

    .container {
      max-width: 1000px;
    }

    .table-dark {
      background-color: #2a2b3d;
    }

    .table thead th {
      border-bottom: 1px solid #444;
    }

    .table-hover tbody tr:hover {
      background-color: #343a50;
    }

    .badge-status {
      padding: 5px 12px;
      border-radius: 12px;
      font-size: 0.85rem;
    }

    .badge-menunggu {
      background-color: #ffc107;
      color: #212529;
    }

    .badge-diterima {
      background-color: #28a745;
    }

    .badge-ditolak {
      background-color: #dc3545;
    }

    a {
      color: #4e9af1;
    }

    a:hover {
      color: #3b83d6;
    }
  </style>
</head>
<body class="d-flex flex-column" style="min-height: 100vh;">
  <div class="d-flex flex-grow-1">
<div class="container" data-aos="fade-up">
  <h2 class="text-center mb-4">Status Pengajuan Skripsi Anda</h2>
  <div class="table-responsive">
    <table class="table table-dark table-hover text-center align-middle">
      <thead>
        <tr>
          <th>Nama</th>
          <th>NIM</th>
          <th>Judul</th>
          <th>Bidang</th>
          <th>Pembimbing</th>
          <th>Status</th>
          <th>Proposal</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $nim = $_SESSION['username']; // anggap NIM disamakan dengan username
        $query = mysqli_query($conn, "SELECT * FROM pengajuan WHERE nim='$nim' ORDER BY tanggal DESC");

        if (mysqli_num_rows($query) == 0) {
            echo "<tr><td colspan='8'>Belum ada pengajuan.</td></tr>";
        }

        while ($data = mysqli_fetch_array($query)) {
            $badge = '';
            switch (strtolower($data['status'])) {
                case 'diterima':
                    $badge = '<span class="badge-status badge-diterima">Diterima</span>'; break;
                case 'ditolak':
                    $badge = '<span class="badge-status badge-ditolak">Ditolak</span>'; break;
                default:
                    $badge = '<span class="badge-status badge-menunggu">Menunggu</span>';
            }

            echo "<tr>
              <td>{$data['nama']}</td>
              <td>{$data['nim']}</td>
              <td>{$data['judul']}</td>
              <td>{$data['bidang']}</td>
              <td>{$data['pembimbing']}</td>
              <td>$badge</td>
              <td><a href='../../uploads/{$data['file']}' target='_blank'>Lihat File</a></td>
              <td>{$data['tanggal']}</td>
            </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
</div>
<script src="../../assets/JS/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
<?php include '../../partials/footer.php'; ?>

</body>
</html>
