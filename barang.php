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
          <h1>Halaman Daftar Barang Terjual</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Data Barang Terjual</h3>
      </div>
      <div class="card-body">
        <table class="table table-bordered" id="example2">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pelanggan</th>
              <th>Nama Barang (Harga Satuan x Jumlah)</th>
              <th>Total Harga Barang</th>
              <th>Total Harga Keseluruhan</th>
              <th>Gambar</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include('koneksi.php'); //memanggil file koneksi

            // Query SQL untuk menggabungkan data barang yang sama berdasarkan pelanggan
            $datas = mysqli_query(
              $koneksi,
              "SELECT c.id, 
                      p.nama AS nama_user, 
                      GROUP_CONCAT(c.name SEPARATOR ', ') AS nama_barang, 
                      GROUP_CONCAT(c.price SEPARATOR ', ') AS harga_satuan,
                      GROUP_CONCAT(c.quantity SEPARATOR ', ') AS jumlah_barang,
                      SUM(c.price * c.quantity) AS total_harga_per_barang,
                      GROUP_CONCAT(c.image SEPARATOR ',') AS images,
                      SUM(c.price * c.quantity) AS total_harga_keseluruhan 
               FROM cart c 
               JOIN pelanggan p ON c.user_id = p.id 
               GROUP BY p.id"
            ) or die(mysqli_error($koneksi));

            $no = 1; // untuk pengurutan nomor

            // melakukan perulangan
            while ($row = mysqli_fetch_assoc($datas)) {
              $nama_barang = explode(', ', $row['nama_barang']);
              $harga_satuan = explode(', ', $row['harga_satuan']);
              $jumlah_barang = explode(', ', $row['jumlah_barang']);
            ?>
              <tr>
                <td><?= $no; ?></td>
                <td><?= $row['nama_user']; ?></td>
                <td>
                  <?php
                  // Menampilkan nama barang, harga satuan, dan jumlah satu per satu
                  for ($i = 0; $i < count($nama_barang); $i++) {
                    echo $nama_barang[$i] . " (Rp " . rupiah($harga_satuan[$i]) . " x " . $jumlah_barang[$i] . ")<br>";
                  }
                  ?>
                </td>
                <td>Rp <?= rupiah($row['total_harga_per_barang']); ?></td>
                <td>Rp <?= rupiah($row['total_harga_keseluruhan']); ?></td>
                <td>
                  <?php
                  // Menampilkan semua gambar dalam satu cell
                  $images = explode(',', $row['images']);
                  foreach ($images as $image) {
                    echo "<a href='assets/img/$image'><img src='assets/img/$image' width='50' style='margin: 2px;'></a>";
                  }
                  ?>
                </td>
                <td style="text-align: center;">
                  <a href="barang.php?id=<?= $row['id']; ?>&status=hapus" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin hapus data ini?');">Hapus</a>
                </td>
              </tr>
            <?php $no++;
            } ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.card-body -->
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('templates/footer.php');
?>

<?php
if ((isset($_GET['status'])) && ($_GET['status'] == 'hapus') && isset($_GET['id'])) {
  $id = $_GET['id']; //menampung id
  //query hapus
  $datas = mysqli_query($koneksi, "DELETE FROM cart WHERE id ='$id'") or die(mysqli_error($koneksi));
  //alert dan redirect ke barang.php
  echo "<script>alert('Data berhasil dihapus.');window.location='barang.php';</script>";
}
?>
