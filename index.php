<?php
include('templates/header.php');
include('templates/sidebar.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Halaman Beranda</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <?php if ($_SESSION['level'] == 'pelanggan') { ?>
    <section class="content">
      <div class="card">
        <div class="card-body text-center">
          <img src="assets/img/logo.jpg" style="width: 320px;">
          <h1 style="font-size: 35px; text-shadow: 1px 1px #000;" class="mt-0 text-dark">TOKO OPTIK GRAND AURA</h1>
        </div>
      </div>
    </section>
  <?php } ?>

  <!-- Main content -->
  <?php if ($_SESSION['level'] == 'admin') { ?>
    <section class="content">
      <div class="row">
        <!-- Karyawan Card -->
        <div class="col-md-4">
          <div class="card bg-primary mb-3">
            <div class="card-header bg-white border-none">
              <h4 class="text-left"><i class="fas fa-user-circle mr-2"></i>Karyawan</h4>
            </div>
            <div class="card-body text-center text-white">
              <h1 class="display-4 mb-0">
                <?php
                include 'koneksi.php';
                $query = "SELECT * FROM karyawan";
                if ($result = mysqli_query($koneksi, $query)) {
                  $row = mysqli_num_rows($result);
                  echo $row;
                }
                ?>
              </h1>
              <p class="lead">Jumlah </p>
            </div>
          </div>
        </div>

        <!-- Pelanggan Card -->
        <div class="col-md-4">
          <div class="card bg-primary mb-3">
            <div class="card-header bg-white border-none">
              <h4 class="text-left"><i class="fas fa-user mr-2"></i>Pelanggan</h4>
            </div>
            <div class="card-body text-center text-white">
              <h1 class="display-4 mb-0">
                <?php
                include 'koneksi.php';
                $query = "SELECT * FROM pelanggan";
                if ($result = mysqli_query($koneksi, $query)) {
                  $row = mysqli_num_rows($result);
                  echo $row;
                }
                ?>
              </h1>
              <p class="lead">Jumlah </p>
            </div>
          </div>
        </div>

        <!-- Layanan Card -->
        <div class="col-md-4">
          <div class="card bg-primary mb-3">
            <div class="card-header bg-white border-none">
              <h4 class="text-left"><i class="fas fa-hands-helping mr-2"></i>Layanan</h4>
            </div>
            <div class="card-body text-center text-white">
              <h1 class="display-4 mb-0">
                <?php
                include 'koneksi.php';
                $query = "SELECT * FROM daftar_barang";
                if ($result = mysqli_query($koneksi, $query)) {
                  $row = mysqli_num_rows($result);
                  echo $row;
                }
                ?>
              </h1>
              <p class="lead">Jumlah </p>
            </div>
          </div>
        </div>

        <!-- Barang Card -->
        <div class="col-md-4">
          <div class="card bg-primary mb-3">
            <div class="card-header bg-white border-none">
              <h4 class="text-left"><i class="fas fa-box mr-2"></i>Barang</h4>
            </div>
            <div class="card-body text-center text-white">
              <h1 class="display-4 mb-0">
                <?php
                include 'koneksi.php';
                $query = "SELECT * FROM daftar_barang";
                if ($result = mysqli_query($koneksi, $query)) {
                  $row = mysqli_num_rows($result);
                  echo $row;
                }
                ?>
              </h1>
              <p class="lead">Jumlah </p>
            </div>
          </div>
        </div>

        <!-- Penjualan Card -->
        <div class="col-md-4">
          <div class="card bg-primary mb-3">
            <div class="card-header bg-white border-none">
              <h4 class="text-left"><i class="fas fa-shopping-cart mr-2"></i>Penjualan</h4>
            </div>
            <div class="card-body text-center text-white">
              <h1 class="display-4 mb-0">
                <?php
                include 'koneksi.php';
                $query = "SELECT * FROM cart";
                if ($result = mysqli_query($koneksi, $query)) {
                  $row = mysqli_num_rows($result);
                  echo $row;
                }
                ?>
              </h1>
              <p class="lead">Jumlah </p>
            </div>
          </div>
        </div>

        <!-- Barang Terlaris Card -->
        <div class="col-md-4">
          <div class="card bg-success mb-3">
            <div class="card-header bg-white border-none">
              <h4 class="text-left"><i class="fas fa-star mr-2"></i>Barang Terlaris</h4>
            </div>
            <div class="card-body text-center text-white">
              <h3 class="display-6 mb-2">
                <?php
                // Query untuk mendapatkan barang terlaris
                $query = "
                  SELECT name, SUM(quantity) as total_terjual 
                  FROM cart 
                  GROUP BY name 
                  ORDER BY total_terjual DESC 
                  LIMIT 1
                ";
                $result = mysqli_query($koneksi, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                  $row = mysqli_fetch_assoc($result);
                  echo $row['name']; // Nama barang terlaris
                } else {
                  echo "Tidak ada data";
                }
                ?>
              </h3>
              <p class="lead">
                Terjual:
                <?php
                if (isset($row['total_terjual'])) {
                  echo $row['total_terjual'] . " unit"; // Jumlah barang terjual
                } else {
                  echo "0 unit";
                }
                ?>
              </p>
            </div>
          </div>
        </div>

        <!-- Barang Paling Sedikit Terjual Card -->
        <div class="col-md-4">
          <div class="card bg-warning mb-3">
            <div class="card-header bg-white border-none">
              <h4 class="text-left"><i class="fas fa-exclamation-circle mr-2"></i>Barang Paling Sedikit Terjual</h4>
            </div>
            <div class="card-body text-center text-white">
              <h3 class="display-6 mb-2">
                <?php
                // Query untuk mendapatkan barang paling sedikit terjual
                $query = "
                  SELECT name, SUM(quantity) as total_terjual 
                  FROM cart 
                  GROUP BY name 
                  ORDER BY total_terjual ASC 
                  LIMIT 1
                ";
                $result = mysqli_query($koneksi, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                  $row = mysqli_fetch_assoc($result);
                  echo $row['name']; // Nama barang paling sedikit terjual
                } else {
                  echo "Tidak ada data";
                }
                ?>
              </h3>
              <p class="lead">
                Terjual:
                <?php
                if (isset($row['total_terjual'])) {
                  echo $row['total_terjual'] . " unit"; // Jumlah barang terjual
                } else {
                  echo "0 unit";
                }
                ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php } ?>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('templates/footer.php');
?>