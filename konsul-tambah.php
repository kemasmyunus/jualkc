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
                    <h1>Halaman Tambah Konsultasi</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Data Konsultasi</h3>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" required="" class="form-control" autofocus="">
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" required="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" name="foto" required="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Surat Keterangan dari Rumah Sakit/Puskesmas</label>
                        <input type="file" name="surat_keterangan" required="" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit" value="simpan">Simpan Data</button>
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

//jika tombol submit ditekan
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $tanggal = $_POST['tanggal'];

    // Upload gambar konsultasi
    $foto = $_FILES['foto']['name'];
    $tmp_foto = $_FILES['foto']['tmp_name'];
    move_uploaded_file($tmp_foto, "assets/img/" . $foto);

    // Upload surat keterangan
    $surat_keterangan = $_FILES['surat_keterangan']['name'];
    $tmp_surat = $_FILES['surat_keterangan']['tmp_name'];
    move_uploaded_file($tmp_surat, "assets/surat/" . $surat_keterangan);

    // Insert data ke dalam tabel konsul
    $query = "INSERT INTO konsul (nama, tanggal, foto, surat_keterangan) VALUES ('$nama', '$tanggal', '$foto', '$surat_keterangan')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Data berhasil disimpan.');window.location='konsul.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data.');</script>";
    }
}
?>
<?php
include('templates/footer.php');
?>