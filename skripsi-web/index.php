<?php
session_start();
include "config/db.php";

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $roles = ['admin', 'mahasiswa', 'dosen'];
    foreach ($roles as $role) {
        $query = mysqli_query($conn, "SELECT * FROM $role WHERE username='$username'");
        $data = mysqli_fetch_array($query);
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
  <title>Login - Sistem Skripsi</title>
  <link rel="stylesheet" href="assets/CSS/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"/>
  <style>
    * {
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: linear-gradient(rgba(30,30,48,0.95), rgba(30,30,48,0.95)), url('assets/img/bg.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #f1f1f1;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-card {
      background-color: #2a2b3d;
      border-radius: 16px;
      padding: 40px 30px;
      width: 360px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.5);
      animation: fadeIn 1s ease;
      text-align: center;
    }

    .login-card img {
      width: 80px;
      margin-bottom: 20px;
    }

    .login-card h3 {
      margin-bottom: 20px;
    }

    .form-control {
      background-color: #1e1e2f;
      border: 1px solid #444;
      color: #f1f1f1;
    }

    .form-control:focus {
      background-color: #1e1e2f;
      color: #fff;
      border-color: #66afe9;
      box-shadow: none;
    }

    .btn-login {
      background-color: #4e9af1;
      border: none;
    }

    .btn-login:hover {
      background-color: #3b83d6;
    }

    .alert {
      background-color: #dc3545;
      border: none;
      color: white;
      padding: 10px;
      font-size: 14px;
      margin-bottom: 20px;
    }

    .small-link {
      font-size: 13px;
      margin-top: 10px;
      color: #aaa;
    }

    .small-link:hover {
      color: #fff;
      text-decoration: underline;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<div class="login-card" data-aos="zoom-in">
  <img src="assets/img/logo.png" alt="Logo Kampus">
  <h3>Login Sistem Skripsi</h3>

  <?php if ($error): ?>
    <div class="alert"><?= $error ?></div>
  <?php endif; ?>

 <form method="POST">
  <div class="mb-3 text-start">
    <label for="username" class="form-label">Username</label>
    <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username Anda" required>
  </div>
  <div class="mb-3 text-start">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password Anda" required>
  </div>
  <button type="submit" class="btn btn-login w-100 mt-2">Login</button>
</form>


  <a href="#" class="small-link">Lupa password?</a>
</div>

<script src="assets/JS/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>

</body>
</html>
