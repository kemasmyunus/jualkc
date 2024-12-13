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
                    <h1>Halaman Edit Konsultasi</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Data Konsultasi</h3>
            </div>
            <div class="card-body">
                <?php
                include('koneksi.php');

                $id = $_GET['id']; // Mengambil id konsultasi yang ingin diubah

                // Menampilkan konsultasi berdasarkan id
                $data = mysqli_query($koneksi, "SELECT * FROM konsul WHERE id = '$id'");
                $row = mysqli_fetch_assoc($data);
                ?>
                <form action="" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="id" required="" value="<?= $row['id']; ?>">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" required="" value="<?= $row['nama']; ?>" class="form-control" autofocus="">
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" required="" value="<?= $row['tanggal']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" name="foto" class="form-control">
                        <br>
                        <img src="assets/img/<?= $row['foto']; ?>" width="200">
                    </div>
                    <div class="form-group">
                        <label>Surat Keterangan</label>
                        <input type="file" name="surat_keterangan" class="form-control">
                        <?php if (!empty($row['surat_keterangan'])) : ?>
                            <br>
                            <a href="assets/surat/<?= $row['surat_keterangan']; ?>" target="_blank"><?= $row['surat_keterangan']; ?></a>
                        <?php endif; ?>
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
// Jika tombol submit diklik, lakukan perubahan data
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $tanggal = $_POST['tanggal'];

    // Update gambar jika ada perubahan
    if ($_FILES['foto']['name'] != '') {
        $foto = $_FILES['foto']['name'];
        $tmp_foto = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmp_foto, "assets/img/" . $foto);
    } else {
        $foto = $row['foto']; // Gunakan gambar lama jika tidak ada perubahan
    }

    // Update surat keterangan jika ada perubahan
    if ($_FILES['surat_keterangan']['name'] != '') {
        $surat_keterangan = $_FILES['surat_keterangan']['name'];
        $tmp_surat = $_FILES['surat_keterangan']['tmp_name'];
        move_uploaded_file($tmp_surat, "assets/surat/" . $surat_keterangan);
    } else {
        $surat_keterangan = $row['surat_keterangan']; // Gunakan surat keterangan lama jika tidak ada perubahan
    }

    // Query untuk melakukan update data
    $query = "UPDATE konsul SET nama='$nama', tanggal='$tanggal', foto='$foto', surat_keterangan='$surat_keterangan' WHERE id ='$id'";
    $result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

    // Redirect ke halaman konsul.php setelah data diubah
    echo "<script>alert('Data berhasil diupdate.');window.location='konsul.php';</script>";
}
?>
<?php
include('templates/footer.php');
?>