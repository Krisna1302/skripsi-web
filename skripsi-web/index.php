<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: " . $_SESSION['role'] . "/dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Sistem Skripsi</title>
  <link rel="stylesheet" href="assets/CSS/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"/>
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }

    body {
      position: relative;
      font-family: 'Segoe UI', sans-serif;
      color: #fff;
      display: flex;
      flex-direction: column;
      background: url('assets/img/bg.jpg') no-repeat center center fixed;
      background-size: cover;
    }

    /* Overlay Gelap */
    body::before {
      content: "";
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7); /* Semakin besar, semakin gelap */
      z-index: 0;
    }

    .main-wrapper {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px 15px;
      z-index: 1; /* Supaya tampil di atas overlay */
    }

    .login-box {
      background-color: rgba(26, 26, 39, 0.95);
      padding: 30px;
      border-radius: 15px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.6);
      animation: fadeIn 0.5s ease;
      z-index: 1;
    }

    .login-box img.logo {
      display: block;
      margin: 0 auto 20px;
      max-width: 80px;
    }

    .login-box h2 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: 600;
      color: #f1f1f1;
    }

    .form-control {
      background-color: #1e1e2f;
      color: #ffffff;
      border: 1px solid #555;
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

    .btn-login {
      background-color: #4e9af1;
      border: none;
      width: 100%;
    }

    .btn-login:hover {
      background-color: #3b83d6;
    }

    footer {
      background-color: #15161d;
      color: #888;
      padding: 15px 0;
      text-align: center;
      font-size: 14px;
      z-index: 1;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 480px) {
      .login-box {
        padding: 20px;
      }

      .login-box img.logo {
        max-width: 60px;
        margin-bottom: 15px;
      }

      footer {
        font-size: 13px;
      }
    }
  </style>
</head>
<body>

<div class="main-wrapper" data-aos="fade-up">
  <div class="login-box">
    <img src="assets/img/logo.png" alt="Logo" class="logo">
    <h2>Login</h2>
    <form method="POST" action="cek.php">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" name="username" placeholder="Masukkan username" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
      </div>
      <button type="submit" class="btn btn-login">Login</button>
    </form>
  </div>
</div>

<?php include 'partials/footer.php'; ?>
<script src="assets/JS/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
