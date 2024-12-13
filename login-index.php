<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TOKO OPTIK GRAND AURA</title>
  <!-- Responsive viewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="./assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="./assets/dist/css/adminlte.min.css">

</head>

<body>
  <div class="container">
    <div class="login-box">
      <div class="login-logo">
        <img src="assets/img/logo.jpg" alt="Logo">
      </div>
      <!-- Login buttons -->
      <div class="login-btn-container">
        <a class="btn btn-app bg-dark btn-pelanggan" href="login-pelanggan.php">
          <span class="badge bg-light">PELANGGAN</span>
          <i class="fas fa-user"></i> LOGIN PELANGGAN
        </a>
        <a class="btn btn-app bg-danger btn-admin" href="login.php">
          <span class="badge bg-light">ADMIN</span>
          <i class="fas fa-user"></i> LOGIN ADMIN
        </a>
      </div>
      <h1 class="text-back">APLIKASI PENDATAAN PEMBELIAN DAN PENJUALAN BARANG OPTIK PADA TOKO OPTIK GRAND AURA BERBASIS WEB</h1>
    </div>
  </div>

  <!-- jQuery -->
  <script src="./assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="./assets/dist/js/adminlte.min.js"></script>

</body>

</html>
<style>
  body {
    font-family: 'Source Sans Pro', sans-serif;
    background: url('assets/img/bg.png') no-repeat center center fixed;
    background-size: cover;
    position: relative;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
  }

  /* Dark overlay for background image */
  body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: -1;
  }

  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  .login-box {
    background: rgba(255, 255, 255, 0.9);
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
    text-align: center;
    width: 100%;
    max-width: 600px;
    z-index: 1;
    transition: transform 0.3s ease-in-out;
  }

  .login-box:hover {
    transform: translateY(-10px);
  }

  .login-logo img {
    width: 200px;
    border-radius: 50%;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease;
  }

  .login-logo img:hover {
    transform: rotate(360deg);
  }

  .btn-app {
    position: relative;
    width: 140px;
    height: 140px;
    border-radius: 50%;
    margin: 20px;
    box-shadow: 5px 5px 15px #b8b8b8, -5px -5px 15px #ffffff;
    transition: all 0.3s;
    color: #fff;
    font-size: 16px;
    text-align: center;
    padding: 20px;
    line-height: 1.2;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-decoration: none;
  }

  .btn-app:hover {
    transform: scale(1.1);
    box-shadow: 2px 2px 10px #b8b8b8, -2px -2px 10px #ffffff;
  }

  .btn-app .badge {
    background-color: #fff;
    color: #333;
    position: absolute;
    top: -15px;
    right: -15px;
    border-radius: 50%;
    padding: 10px;
    font-size: 14px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  }

  /* Specific button backgrounds */
  .btn-pelanggan {
    background-color: #343a40; /* Dark background for Pelanggan */
  }

  .btn-admin {
    background-color: #dc3545; /* Danger background for Admin */
  }

  .text-back {
    color: #333;
    font-size: 20px;
    font-weight: bold;
    margin-top: 40px;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
  }

  .login-btn-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 30px;
    flex-wrap: wrap;
  }
</style>
