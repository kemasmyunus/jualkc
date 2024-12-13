<?php
include('koneksi.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM bayar WHERE id='$id'";
    $result = mysqli_query($koneksi, $query);
    $order = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = $_POST['status'];
        $update_query = "UPDATE bayar SET status='$status' WHERE id='$id'";
        if (mysqli_query($koneksi, $update_query)) {
            echo "<script>alert('Status berhasil diperbarui.');window.location='pelacakan.php';</script>";
        } else {
            echo "<p>Gagal memperbarui status.</p>";
        }
    }
} else {
    echo "<p>Data tidak ditemukan.</p>";
}
?>
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
                <h1>Edit Status</h1>
                <form method="POST">
                    <label for="status">Pilih Status:</label>
                    <select name="status" id="status">
                        <option value="Sedang diproses" <?= $order['status'] == 'Sedang diproses' ? 'selected' : ''; ?>>SEDANG PROSES</option>
                        <option value="DIKIRIM" <?= $order['status'] == 'DIKIRIM' ? 'selected' : ''; ?>>DIKIRIM</option>
                        <option value="SELESAI" <?= $order['status'] == 'SELESAI' ? 'selected' : ''; ?>>SELESAI</option>
                        <option value="RETUR DIAJUKAN" <?= $order['status'] == 'RETUR DIAJUKAN' ? 'selected' : ''; ?>>RETUR DIAJUKAN</option>
                        <option value="RETUR DISETUJUI" <?= $order['status'] == 'RETUR DISETUJUI' ? 'selected' : ''; ?>>RETUR DISETUJUI</option>
                        <option value="RETUR DITOLAK" <?= $order['status'] == 'RETUR DITOLAK' ? 'selected' : ''; ?>>RETUR DITOLAK</option>
                    </select>
                    <button type="submit">Update Status</button>
                </form>
            </div>
            <!-- /.card-body -->
            <!-- /.card -->

    </section>
    <!-- /.content -->
</div>

<?php
include('templates/footer.php');
?>
