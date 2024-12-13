<?php
include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id='$id'");
    $karyawan = mysqli_fetch_array($data);
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Halaman Edit Karyawan</h1>
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
        <form action="" method="post" role="form">
          <div class="form-group">
            <label>NIP</label>
            <input type="text" name="nip" required="" class="form-control" value="<?php echo $karyawan['nip']; ?>">
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama_karyawan" required="" class="form-control" value="<?php echo $karyawan['nama_karyawan']; ?>">
          </div>
          <div class="form-group">
            <label>Jenis Kelamin</label>
            <select class="form-control" name="kelamin" required="">
              <option value="L" <?php if ($karyawan['kelamin'] == 'L') echo 'selected'; ?>>Laki - Laki</option>
              <option value="P" <?php if ($karyawan['kelamin'] == 'P') echo 'selected'; ?>>Wanita</option>
            </select>
          </div>
          <div class="form-group">
            <label>Jabatan</label>
            <select class="form-control" name="jabatan" required="">
              <option value="Pimpinan" <?php if ($karyawan['jabatan'] == 'Pimpinan') echo 'selected'; ?>>Pimpinan</option>
              <option value="Admin" <?php if ($karyawan['jabatan'] == 'Admin') echo 'selected'; ?>>Admin</option>
              <option value="karyawan" <?php if ($karyawan['jabatan'] == 'karyawan') echo 'selected'; ?>>Karyawan</option>
            </select>
          </div>
          <div class="form-group">
            <label>No Hp</label>
            <input type="text" name="no_hp" required="" class="form-control" value="<?php echo $karyawan['no_hp']; ?>">
          </div>
          <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal" required="" class="form-control" value="<?php echo $karyawan['tanggal']; ?>">
          </div>
          <div class="form-group">
            <label>Agama</label>
            <select class="form-control" name="agama" required="">
              <option value="islam" <?php if ($karyawan['agama'] == 'islam') echo 'selected'; ?>>Islam</option>
              <option value="keristen" <?php if ($karyawan['agama'] == 'keristen') echo 'selected'; ?>>Keristen</option>
              <option value="hindu" <?php if ($karyawan['agama'] == 'hindu') echo 'selected'; ?>>Hindu</option>
              <option value="budha" <?php if ($karyawan['agama'] == 'budha') echo 'selected'; ?>>Budha</option>
            </select>
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" required="" class="form-control" value="<?php echo $karyawan['alamat']; ?>">
          </div>
          <div class="form-group">
            <label>Pendidikan Terakhir</label>
            <select class="form-control" name="pendidikan" required="">
              <option value="SD" <?php if ($karyawan['pendidikan'] == 'SD') echo 'selected'; ?>>SD</option>
              <option value="SMP" <?php if ($karyawan['pendidikan'] == 'SMP') echo 'selected'; ?>>SMP</option>
              <option value="SMA" <?php if ($karyawan['pendidikan'] == 'SMA') echo 'selected'; ?>>SMA</option>
              <option value="D3" <?php if ($karyawan['pendidikan'] == 'D3') echo 'selected'; ?>>D3</option>
              <option value="S1" <?php if ($karyawan['pendidikan'] == 'S1') echo 'selected'; ?>>S1</option>
              <option value="S2" <?php if ($karyawan['pendidikan'] == 'S2') echo 'selected'; ?>>S2</option>
              <option value="S3" <?php if ($karyawan['pendidikan'] == 'S3') echo 'selected'; ?>>S3</option>
            </select>
          </div>
          <div class="form-group">
            <label>Gaji</label>
            <input type="number" name="gaji" required="" class="form-control" value="<?php echo $karyawan['gaji']; ?>">
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required="" class="form-control" value="<?php echo $karyawan['username']; ?>">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required="" class="form-control" value="<?php echo $karyawan['password']; ?>">
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
  $username = $_POST['username'];
  $password = $_POST['password'];

  $datas = mysqli_query($koneksi, "UPDATE karyawan SET nip='$nip', nama_karyawan='$nama_karyawan', kelamin='$kelamin', jabatan='$jabatan', no_hp='$no_hp', tanggal='$tanggal', agama='$agama', alamat='$alamat', pendidikan='$pendidikan', gaji='$gaji', username='$username', password='$password' WHERE id='$id'") or die(mysqli_error($koneksi));

  echo "<script>alert('Data berhasil diperbarui.');window.location='karyawan-index.php';</script>";
}
?>
<?php
include('templates/footer.php');
?>
