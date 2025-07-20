<?php
session_start();
include "config/db.php";

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $roles = ['admin', 'mahasiswa', 'dosen'];
    foreach ($roles as $role) {
        $query = mysqli_query($conn, "SELECT * FROM $role WHERE username='$username' LIMIT 1");
        $data = mysqli_fetch_assoc($query);

        if ($data && password_verify($password, $data['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            header("Location: $role/dashboard.php");
            exit;
        }
    }

    $error = "Login gagal! Username atau password salah.";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="assets/CSS/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"/>
  <style>
    body {
      background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)),
        url('assets/img/bg.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      font-family: Arial, sans-serif;
    }

    .login-box {
      width: 400px;
      margin: 10vh auto;
      padding: 30px;
      background-color: #2a2b3d;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.5);
      animation: fadeIn 1s ease-in-out;
    }

    .login-box img {
      display: block;
      margin: 0 auto 20px;
      width: 80px;
    }

    .login-box h3 {
      text-align: center;
      margin-bottom: 25px;
    }

    .form-control {
      background-color: #1e1e2f;
      border: 1px solid #555;
      color: #fff;
    }

    .form-control::placeholder {
      color: #bbb;
    }

    .btn-primary {
      background-color: #4e9af1;
      border: none;
    }

    .btn-primary:hover {
      background-color: #3b83d6;
    }

    .alert {
      background-color: #dc3545;
      color: #fff;
      padding: 10px;
      border: none;
      margin-bottom: 15px;
      text-align: center;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body class="d-flex flex-column" style="min-height: 100vh;">

<div class="login-box" data-aos="zoom-in">
  <img src="assets/img/logo.png" alt="Logo Kampus">
  <h3>Login Sistem Skripsi</h3>

  <?php if ($error): ?>
    <div class="alert"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Login</button>
  </form>
</div>

<?php include 'partials/footer.php'; ?>

<script src="assets/JS/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
