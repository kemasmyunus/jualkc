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
                    <h1>Halaman Surat Konsultasi</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <?php if ($_SESSION['level'] == 'pelanggan') { ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Data Konsultasi Dokter</h3>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group ">
                            <label>Nama</label>
                            <input type="text" name="nama" required="" class="form-control" autofocus=""  value="<?= $_SESSION['nama']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" required="" class="form-control" id="tanggal">
                        </div>
                        <div class="form-group">
                            <label>Gambar</label>
                            <input type="file" name="foto" required="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Surat Keterangan Konsultasi dari Dokter/BPJS</label>
                            <input type="file" name="surat_keterangan" required="" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit" value="simpan">Simpan Data</button>
                    </form>
                </div>
            </div>
        <?php } ?>
        <?php if ($_SESSION['level'] == 'admin') { ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data</h3>
                    <?php if ($_SESSION['level'] == 'admin') : ?>
                        <a href="konsul-tambah.php" class="btn btn-sm btn-success float-right">+ Tambah Data</a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="example2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Gambar Hasil Test</th>
                                <th>Surat Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('koneksi.php'); //memanggil file koneksi
                            $datas = mysqli_query($koneksi, "select * from konsul") or die(mysqli_error($koneksi));

                            $no = 1; //untuk pengurutan nomor

                            //melakukan perulangan
                            while ($row = mysqli_fetch_assoc($datas)) {
                            ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $row['nama']; ?></td>
                                    <td><?= $row['tanggal']; ?></td>
                                    <td><a href="assets/img/<?= $row['foto']; ?>"><img src="assets/img/<?= $row['foto']; ?>" width="100"></a></td>
                                    <td><a href="assets/surat/<?= $row['surat_keterangan']; ?>" target="_blank"><?= $row['surat_keterangan']; ?></a></td>
                                    <td style="text-align: center;">
                                        <?php if ($_SESSION['level'] == 'admin') { ?>
                                            <a href="edit-konsul.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="konsul.php?id=<?= $row['id']; ?>&status=hapus" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini?');">Hapus</a>
                                        <?php } ?>

                                    </td>
                                </tr>
                            <?php
                                $no++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('templates/footer.php');
?>

<?php
// Bagian ini untuk menghapus data
if ((isset($_GET['status'])) && ($_GET['status'] == 'hapus')) {
    $id = $_GET['id']; // Menampung id konsultasi yang akan dihapus

    // Query hapus data konsultasi berdasarkan id
    $datas = mysqli_query($koneksi, "DELETE FROM konsul WHERE id ='$id'") or die(mysqli_error($koneksi));

    // Alert dan redirect ke konsul.php setelah data dihapus
    echo "<script>alert('Data konsultasi berhasil dihapus.');window.location='konsul.php';</script>";
}
?>

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
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal').value = today;
    });
</script>