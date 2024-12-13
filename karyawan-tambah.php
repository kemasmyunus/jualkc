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
          <h1>Halaman Tambah karyawan</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tambah Data</h3>
      </div>
      <div class="card-body">
        <form action="" method="post" role="form">
          <div class="form-group">
            <label>NIP</label>
            <input type="text" name="nip" required="" class="form-control">
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama_karyawan" required="" class="form-control">
          </div>
          <div class="form-group">
            <label>Jenis Kelamin</label>
            <select class="form-control  " name="kelamin" required="">
              <option value="">Pilih</option>
              <option value="L">Laki - Laki</option>
              <option value="P">Wanita</option>
            </select>
          </div>
          <div class="form-group">
            <label>Jabatan</label>
            <select class="form-control  " name="jabatan" required="">
              <option value="">Pilih</option>
              <option value="Pimpinan">Pimpinan</option>
              <option value="Admin">Admin</option>
              <option value="karyawan">karyawan</option>
            </select>
          </div>
          <div class="form-group">
            <label>No Hp</label>
            <input type="text" name="no_hp" required="" class="form-control">
          </div>
          <div class="form-group">
            <label>tanggal lahir</label>
            <input type="date" name="tanggal" required="" class="form-control">
          </div>
          <div class="form-group">
            <label>Agama</label>
            <select class="form-control  " name="agama" required="">
              <option value="">Pilih</option>
              <option value="islam">islam</option>
              <option value="keristen">keristen</option>
              <option value="hindu">hindu</option>
              <option value="budha">budha</option>
            </select>
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" required="" class="form-control">
          </div>
          <div class="form-group">
            <label>Pendidikan Terakhir</label>
            <select class="form-control" name="pendidikan" required="">
              <option value="">Pilih</option>
              <option value="SD">SD</option>
              <option value="SMP">SMP</option>
              <option value="SMA">SMA</option>
              <option value="D3">D3</option>
              <option value="S1">S1</option>
              <option value="S2">S2</option>
              <option value="S3">S3</option>
            </select>
          </div>

          <div class="form-group">
            <label>Gaji</label>
            <input type="number" name="gaji" required="" class="form-control">
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required="" class="form-control">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required="" class="form-control">
          </div>

          <button type="submit" class="btn btn-primary" name="submit" value="simpan">Simpan data</button>
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
include('koneksi.php');

//melakukan pengecekan jika button submit diklik maka akan menjalankan perintah simpan dibawah ini
if (isset($_POST['submit'])) {
  $nip = $_POST['nip'];
  $nama_karyawan = $_POST['nama_karyawan'];
  $kelamin = $_POST['kelamin'];
  $jabatan = $_POST['jabatan'];
  $no_hp = $_POST['no_hp'];
  $tanggal = $_POST['tanggal'];
  $agama = $_POST['agama'];
  $alamat = $_POST['alamat'];
  $pendidikan = $_POST['pendidikan'];
  $gaji = $_POST['gaji'];
  $status_aktif = 'aktif';
  $username = $_POST['username'];
  $password = $_POST['password'];

  $datas = mysqli_query($koneksi, "insert into karyawan (nip, nama_karyawan, kelamin, jabatan, no_hp, tanggal, agama, alamat, pendidikan, gaji, status_aktif, username, password) values ('$nip', '$nama_karyawan', '$kelamin', '$jabatan', '$no_hp', '$tanggal', '$agama', '$alamat', '$pendidikan', '$gaji', '$status_aktif', '$username', '$password')") or die(mysqli_error($koneksi));

  echo "<script>alert('data berhasil disimpan.');window.location='karyawan-index.php';</script>";
}
?>
<?php
include('templates/footer.php');
?>