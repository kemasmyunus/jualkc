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
          <h1>Halaman Edit Daftar Barang</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Edit Data</h3>
      </div>
      <div class="card-body">
        <?php
        include('koneksi.php');

        $id = $_GET['id']; //mengambil id stok yang ingin diubah

        //menampilkan stok berdasarkan id
        $data   = mysqli_query($koneksi, "select * from daftar_barang where id = '$id'");
        $row  = mysqli_fetch_assoc($data);
        ?>
        <form action="" method="post" role="form">
          <input type="hidden" name="id" required="" value="<?= $row['id']; ?>">
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" required="" value="<?= $row['nama']; ?>" class="form-control" autofocus="">
          </div>
          <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" name="deskripsi" required="" value="<?= $row['deskripsi']; ?>" class="form-control" autofocus="">
          </div>
          <div class="form-group">
            <label>Satuan</label>
            <input type="text" name="satuan" required="" value="<?= $row['satuan']; ?>" class="form-control">
          </div>
          <div class="form-group">
            <label>Harga Beli</label>
            <input type="number" name="harga_beli" required="" value="<?= $row['harga_beli']; ?>" class="form-control">
          </div>
          <div class="form-group">
            <label>Harga Jual</label>
            <input type="number" name="harga_jual" required="" value="<?= $row['harga_jual']; ?>" class="form-control">
          </div>
          <div class="form-group">
            <label>Merek</label>
            <input type="text" name="merek" required="" value="<?= $row['merek']; ?>" class="form-control">
          </div>
          <div class="form-group">
            <label>Gambar</label>
            <input type="file" name="foto" required="" value="<?= $row['foto']; ?>" class="form-control">
          </div>

          <button type="submit" class="btn btn-primary" name="submit" value="simpan">Ubah data</button>
        </form>
      </div>
    </div>
    <!-- /.card-body -->
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php

//jika klik tombol submit maka akan melakukan perubahan
if (isset($_POST['submit'])) {
  $id = $_POST['id'];
  $nama = $_POST['nama'];
  $deskripsi = $_POST['ndeskripsiama'];
  $satuan = $_POST['satuan'];
  $harga_beli = $_POST['harga_beli'];
  $harga_jual = $_POST['harga_jual'];
  $merek = $_POST['merek'];
  $foto = $_POST['foto'];

  mysqli_query($koneksi, "update daftar_barang set nama='$nama', deskripsi='$deskripsi', satuan='$satuan',harga_beli='$harga_beli',harga_jual='$harga_jual',merek='$merek',foto='$foto' where id ='$id'") or die(mysqli_error($koneksi));

  //redirect ke halaman index.php
  echo "<script>alert('data berhasil diupdate.');window.location='stok-index.php';</script>";
}
?>
<?php
include('templates/footer.php');
?>