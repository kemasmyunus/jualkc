<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('koneksi.php');
include('templates/header.php');
include('templates/sidebar.php');

// Asumsikan user_id disimpan di sesi setelah pengguna login
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // Tentukan query berdasarkan peran pengguna
    if ($_SESSION['level'] == 'admin') {
        $query = "SELECT retur.*, bayar.alamat, bayar.telepon, bayar.tracking_number, bayar.status, cart.name, cart.price, cart.quantity, pelanggan.nama AS user_name
                  FROM retur 
                  JOIN bayar ON retur.bayar_id = bayar.id 
                  JOIN cart ON retur.id_cart = cart.id 
                  JOIN pelanggan ON retur.user_id = pelanggan.id";
    } else {
        $query = "SELECT retur.*, bayar.alamat, bayar.telepon, bayar.tracking_number, bayar.status, cart.name, cart.price, cart.quantity, pelanggan.nama AS user_name
                  FROM retur 
                  JOIN bayar ON retur.bayar_id = bayar.id 
                  JOIN cart ON retur.id_cart = cart.id 
                  JOIN pelanggan ON retur.user_id = pelanggan.id
                  WHERE retur.user_id = $user_id";
    }

    $result = mysqli_query($koneksi, $query);
} else {
    // Jika tidak ada user_id di sesi, arahkan pengguna ke halaman login
    header('Location: login.php');
    exit;
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daftar Retur</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Retur</th>
                            <th>Nama Pengguna</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Alasan Retur</th>
                            <th>Tracking Number</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= $row['user_name']; ?></td>
                                <td><?= $row['name']; ?></td>
                                <td>Rp. <?= number_format($row['price'], 0, ',', '.'); ?></td>
                                <td><?= $row['quantity']; ?></td>
                                <td><?= $row['alasan_retur']; ?></td>
                                <td><?= $row['tracking_number']; ?></td>
                                <td><?= $row['status']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php include('templates/footer.php'); ?>
