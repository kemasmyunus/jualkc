<?php
include('koneksi.php');
include('templates/header.php');
include('templates/sidebar.php');

// Ambil kode terbesar dari tabel pelanggan
$query = mysqli_query($koneksi, "SELECT MAX(kode) AS kodeTerbesar FROM pelanggan");
$data = mysqli_fetch_array($query);
$kodeTerbesar = $data['kodeTerbesar'];

// Pisahkan kode dari nomor urut
// Asumsi kode dimulai dengan huruf 'SH' diikuti oleh angka, misalnya 'SH0001'
$urutan = (int) substr($kodeTerbesar, 2); // Mengambil bagian numerik dari kode
$urutan++; // Meningkatkan urutan untuk kode berikutnya

$huruf = "SH";
$kode = $huruf . sprintf("%04s", $urutan); // Membentuk kode baru

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Halaman Tambah Pelanggan</h1>
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
        <form action="" method="post" role="form" enctype="multipart/form-data">
          <div class="form-group">
            <label>Kode</label>
            <input type="text" name="kode" value="<?= $kode; ?>" required class="form-control" readonly>
          </div>

          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" required class="form-control">
          </div>
          <div class="form-group">
            <label>Umur</label>
            <input type="text" name="umur" required class="form-control">
          </div>
          <div class="form-group">
            <label>Kelamin</label>
            <select class="form-control" name="kelamin" required>
              <option value="">Pilih</option>
              <option value="Pria">Pria</option>
              <option value="Wanita">Wanita</option>
            </select>
          </div>
          <div class="form-group">
            <label>No Hp</label>
            <input type="text" name="hp" required class="form-control">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required class="form-control">
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" required class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required class="form-control">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required class="form-control">
          </div>

          <button type="submit" class="btn btn-primary" name="submit" value="simpan">Simpan data</button>
        </form>
      </div>
    </div>
  </section>
</div>

<?php
// Menyimpan data pelanggan ke database
if (isset($_POST['submit'])) {
  $kode = $_POST['kode'];
  $nama = $_POST['nama'];
  $umur = $_POST['umur'];
  $hp = $_POST['hp'];
  $alamat = $_POST['alamat'];
  $email = $_POST['email'];
  $kelamin = $_POST['kelamin'];
  $username = $_POST['username'];
  $password = $_POST['password']; // Amankan password
  $tgl_daftar = date('Y-m-d');
  $verifikasi = 'waiting';

  // Query untuk menyimpan data pelanggan
  $sql = "INSERT INTO pelanggan (kode, nama,umur, hp, alamat, email, kelamin, username, password, verifikasi, tgl_daftar) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
  $stmt = $koneksi->prepare($sql);
  $stmt->bind_param("sssssssssss", $kode, $nama, $umur, $hp, $alamat, $email, $kelamin, $username, $password, $verifikasi, $tgl_daftar);

  if ($stmt->execute()) {
    echo "<script>alert('Data berhasil disimpan.'); window.location='pelanggan-index.php';</script>";
  } else {
    echo "<script>alert('Data gagal disimpan.'); window.location='pelanggan-index.php';</script>";
  }
}
include('templates/footer.php');
?>