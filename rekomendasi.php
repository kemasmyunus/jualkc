<?php
include('koneksi.php');
include('templates/header.php');
include('templates/sidebar.php');

// Handle form submission for adding recommendations
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_recommendation'])) {
    $pelanggan_id = $_POST['pelanggan_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $color = $_POST['color'];
    $size = $_POST['size'];

    $query = "INSERT INTO rekomendasi (pelanggan_id, product_id, quantity, color, size) VALUES ('$pelanggan_id', '$product_id', '$quantity', '$color', '$size')";
    mysqli_query($koneksi, $query) or die('Query failed: ' . mysqli_error($koneksi));
    echo "<script>alert('Recommendation added successfully!');window.location='rekomendasi.php';</script>";
}

// Handle deletion of recommendations
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $query = "DELETE FROM rekomendasi WHERE id='$delete_id'";
    mysqli_query($koneksi, $query) or die('Query failed: ' . mysqli_error($koneksi));
    echo "<script>alert('Recommendation deleted successfully!');window.location='rekomendasi.php';</script>";
}

// Fetch data for dropdowns
$pelanggan_query = "SELECT id, nama FROM pelanggan";
$pelanggan_result = mysqli_query($koneksi, $pelanggan_query) or die('Query failed: ' . mysqli_error($koneksi));

$barang_query = "SELECT id, nama FROM daftar_barang";
$barang_result = mysqli_query($koneksi, $barang_query) or die('Query failed: ' . mysqli_error($koneksi));
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Rekomendasi</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- Input Recommendation Form -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Input Barang Rekomendasi</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="pelanggan_id">ID Pelanggan:</label>
                                    <select id="pelanggan_id" name="pelanggan_id" class="form-control" required>
                                        <option value="">Pilih Pelanggan</option>
                                        <?php while ($row = mysqli_fetch_assoc($pelanggan_result)) { ?>
                                            <option value="<?= $row['id']; ?>"><?= $row['id']; ?> - <?= $row['nama']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="product_id">ID Produk:</label>
                                    <select id="product_id" name="product_id" class="form-control" required>
                                        <option value="">Pilih Produk</option>
                                        <?php while ($row = mysqli_fetch_assoc($barang_result)) { ?>
                                            <option value="<?= $row['id']; ?>"><?= $row['id']; ?> - <?= $row['nama']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="quantity">Jumlah:</label>
                                    <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Masukkan Jumlah" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="color">Warna:</label>
                                    <select id="color" name="color" class="form-control" required>
                                        <option value="">Pilih Warna</option>
                                        <option value="Merah">Merah</option>
                                        <option value="Biru">Biru</option>
                                        <option value="Hitam">Hitam</option>
                                        <option value="Kuning">Kuning</option>
                                        <option value="Polos">Polos</option>
                                    </select>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="size">Ukuran:</label>
                                    <select id="size" name="size" class="form-control" required>
                                        <option value="">Pilih Ukuran</option>    
                                        <option value="0.0">0.0</option>
                                        <option value="1.0">1.0</option>
                                        <option value="2.0">2.0</option>
                                        <option value="3.0">3.0</option>
                                        <option value="4.0">4.0</option>
                                        <!-- Add more options dynamically based on your database -->
                                    </select>
                                </div>
                                <div class="col-md-12 form-group">
                                    <button type="submit" name="add_recommendation" class="btn btn-primary">Tambah Rekomendasi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Recommendation History -->
            <div class="col-lg-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Riwayat Barang Rekomendasi</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Fetch recommendation history
                        $query = "SELECT rekomendasi.id, rekomendasi.pelanggan_id, pelanggan.nama AS pelanggan_nama, rekomendasi.product_id, daftar_barang.nama AS product_nama, rekomendasi.quantity, rekomendasi.color, rekomendasi.size
                                  FROM rekomendasi
                                  INNER JOIN pelanggan ON rekomendasi.pelanggan_id = pelanggan.id
                                  INNER JOIN daftar_barang ON rekomendasi.product_id = daftar_barang.id";
                        $result = mysqli_query($koneksi, $query) or die('Query failed: ' . mysqli_error($koneksi));

                        if (mysqli_num_rows($result) > 0) {
                        ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ID Pelanggan</th>
                                        <th>Nama Pelanggan</th>
                                        <th>ID Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Jumlah</th>
                                        <th>Warna</th>
                                        <th>Ukuran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?= $row['id']; ?></td>
                                            <td><?= $row['pelanggan_id']; ?></td>
                                            <td><?= $row['pelanggan_nama']; ?></td>
                                            <td><?= $row['product_id']; ?></td>
                                            <td><?= $row['product_nama']; ?></td>
                                            <td><?= $row['quantity']; ?></td>
                                            <td><?= $row['color']; ?></td>
                                            <td><?= $row['size']; ?></td>
                                            <td>
                                                <a href="rekomendasi.php?delete_id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this recommendation?');">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <p class="text-center">Belum ada riwayat rekomendasi.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('templates/footer.php'); ?>
