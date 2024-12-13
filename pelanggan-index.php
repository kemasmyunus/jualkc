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
          <h1>Halaman Pelanggan</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Data</h3>
        <a href="pelanggan-tambah.php" class="btn btn-sm btn-success float-right">+ Tambah Data</a>
      </div>
      <div class="card-body">
        <table class="table table-bordered" id="example2">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Usia</th>
              <th>jenis kelamin</th>
              <th>No Hp</th>
              <th>Email</th>
              <th>Alamat</th>
              <th>Status</th>
              <th>Tgl Pendaftaran</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include('koneksi.php'); //memanggil file koneksi
            $datas = mysqli_query($koneksi, "select * from pelanggan") or die(mysqli_error($koneksi));

            $no = 1; //untuk pengurutan nomor

            //melakukan perulangan
            while ($row = mysqli_fetch_assoc($datas)) {
            ?>

              <tr>
                <td><?= $no; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['umur']; ?></td>
                <td><?= $row['kelamin']; ?></td>
                <td><?= $row['hp']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['alamat']; ?></td>
                <td><?= $row['verifikasi']; ?></td>
                <td><?= $row['tgl_daftar']; ?></td>
                <!--             <td><img src="assets/gambar/<?= $row['foto']; ?>" width="100"></td> -->
                <td style="text-align: center;">
                  <a href="pelanggan-edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="pelanggan-index.php?id=<?= $row['id']; ?>&status=hapus" class="btn btn-sm btn-danger" onclick="return confirm('anda yakin ingin hapus data ini?');">Hapus</a>
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
if ((isset($_GET['status'])) && ($_GET['status'] == 'hapus')) {
  $id = $_GET['id']; //menampung id
  //query hapus
  $datas = mysqli_query($koneksi, "delete from pelanggan where id ='$id'") or die(mysqli_error($koneksi));
  //alert dan redirect ke index.php
  echo "<script>alert('data berhasil dihapus.');window.location='pelanggan-index.php';</script>";
}
?>
