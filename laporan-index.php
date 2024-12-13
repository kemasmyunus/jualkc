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
          <h1>Halaman Laporan</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-body">
        <h3 class="mb-4">Pengaturan Nama TTD</h3>
        <?php
        include('koneksi.php');
        $data_ttd = mysqli_query($koneksi, "SELECT * FROM pengaturan WHERE id = '1'");
        $row_ttd = mysqli_fetch_assoc($data_ttd);
        ?>
        <form action="" method="post" role="form">
          <div class="input-group mb-3">
            <input type="text" name="ttd" class="form-control form-control-sm col-4" value="<?= $row_ttd['ttd']; ?>">
            <button type="submit" class="btn btn-primary btn-sm" name="submit" value="simpan">Update</button>
          </div>
        </form>
        <?php
        if (isset($_POST['submit'])) {
          $id = '1';
          $ttd = $_POST['ttd'];
          $datas = mysqli_query($koneksi, "UPDATE pengaturan SET ttd = '$ttd' WHERE id = '$id'") or die(mysqli_error($koneksi));
          echo "<script>window.location='laporan-index.php';</script>";
        }
        ?>
      </div>
    </div>

    <!-- Laporan section -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Daftar Laporan</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <?php
              // Array laporan untuk di-loop dan ditampilkan
              $laporan = [
                ["Laporan Pelanggan", "laporan-pelanggan.php"],
                ["Laporan Retur", "laporan-retur.php"],
                ["Laporan Karyawan ", "laporan-karyawan.php"],
                ["Laporan Barang", "laporan-Barang.php"],
                ["Laporan Konsultasi", "laporan-konsul.php"],
                ["Laporan Penjualan", "laporan-penjualan.php"],
                ["Laporan Pembayaran", "laporan-pembayaran.php"],
                ["Laporan Saran/Komentar", "laporan-feedback.php"],
                

                ["Laporan Untung dan Rugi", "laporan-untungdanrugi.php"]

              ];

              foreach ($laporan as $lapor) {
              ?>
                <div class="col-md-4 mb-3">
                  <div class="card shadow-sm">
                    <div class="card-body text-center">
                      <h5 class="card-title"><?= $lapor[0]; ?></h5>
                      <a href="<?= $lapor[1]; ?>" class="btn btn-warning btn-sm" target="_blank">
                        <i class="fas fa-print"></i> Cetak!
                      </a>
                    </div>
                  </div>
                </div>
              <?php } ?>
              <div class="col-md-6 mb-3">
                <div class="card shadow-sm">
                  <div class="card-body text-center">
                    <h5 class="card-title">Laporan History Transaksi Pelanggan</h5>
                    <form method="get" action="laporan-transaksi.php" class="form-inline d-flex justify-content-center">
                      <select class="form-control col-sm-6 mr-2" name="pelanggan_id" required="">
                        <option value="">Pilih Pelanggan</option>
                        <?php
                        $datas = mysqli_query($koneksi, "SELECT * FROM pelanggan") or die(mysqli_error($koneksi));
                        while ($row = mysqli_fetch_assoc($datas)) {
                        ?>
                          <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                        <?php } ?>
                      </select>
                      <button type="submit" class="btn btn-warning btn-sm" name="submit">
                        <i class="fas fa-print"></i> Cetak!
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div> <!-- row -->
          </div> <!-- card-body -->
        </div> <!-- card -->
      </div> <!-- col-md-12 -->
    </div> <!-- row -->
  </section> <!-- content -->
</div> <!-- content-wrapper -->

<?php
include('templates/footer.php');
?>