<?php
ob_start(); // Start output buffering

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('koneksi.php');
include('templates/header.php');
include('templates/sidebar.php');

// Handle deletion request
if (isset($_GET['status']) && $_GET['status'] === 'hapus' && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the ID

    // Query to delete the record
    $delete_query = "DELETE FROM bayar WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $delete_query);
    mysqli_stmt_bind_param($stmt, 'i', $id);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: pelacakan.php'); // Redirect to the same page to refresh the list
        ob_end_flush();
        exit;
    } else {
        die('Error deleting record: ' . mysqli_error($koneksi));
    }
}

// Assume user_id is stored in the session after login
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('Location: login.php');
    ob_end_flush();
    exit;
}

// Query to fetch tracking data
if ($_SESSION['level'] === 'admin') {
    $query = "SELECT bayar.*, cart.name, cart.price, cart.quantity, pelanggan.nama AS customer_name
              FROM bayar
              JOIN cart ON bayar.id_cart = cart.id
              JOIN pelanggan ON bayar.user_id = pelanggan.id";
} else {
    $query = "SELECT bayar.*, cart.name, cart.price, cart.quantity, pelanggan.nama AS customer_name
              FROM bayar
              JOIN cart ON bayar.id_cart = cart.id
              JOIN pelanggan ON bayar.user_id = pelanggan.id
              WHERE bayar.user_id = ?";
}

$stmt = mysqli_prepare($koneksi, $query);

if ($_SESSION['level'] !== 'admin') {
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die('Query Error: ' . mysqli_error($koneksi));
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pelacakan Pesanan</h1>
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
                            <th>No</th>
                            <?php if ($_SESSION['level'] === 'admin') { ?>
                                <th>Nama Pelanggan</th>
                            <?php } ?>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Tracking Number</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php                        
                        $no = 1; // Untuk pengurutan nomor
                        while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <?php if ($_SESSION['level'] === 'admin') { ?>
                                    <td><?= htmlspecialchars($row['customer_name']); ?></td>
                                <?php } ?>
                                <td><?= htmlspecialchars($row['name']); ?></td>
                                <td>Rp. <?= number_format($row['price'], 0, ',', '.'); ?></td>
                                <td><?= htmlspecialchars($row['quantity']); ?></td>
                                <td>Rp. <?= number_format($row['price'] * $row['quantity'], 0, ',', '.'); ?></td>
                                <td><?= htmlspecialchars($row['tracking_number']); ?></td>
                                <td><?= htmlspecialchars($row['status']); ?></td>
                                <td>
                                    <?php if ($_SESSION['level'] === 'admin') { ?>
                                        <a href="edit-status.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="pelacakan.php?id=<?= $row['id']; ?>&status=hapus" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini?');">Hapus</a>
                                    <?php } ?>
                                    <?php if ($_SESSION['level'] === 'pelanggan') { ?>
                                        <!-- Tombol Return -->
<a href="print_receipt.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-secondary" target="_blank">Cetak Nota</a> <!-- New print receipt button -->

                                        <?php if ($row['status'] !== 'RETUR') : ?>
                                            <form action="return_process.php" method="post">
                                                <input type="hidden" name="bayar_id" value="<?= htmlspecialchars($row['id']); ?>">
                                                <input type="hidden" name="id_cart" value="<?= htmlspecialchars($row['id_cart']); ?>">
                                                <input type="hidden" name="tracking_number" value="<?= htmlspecialchars($row['tracking_number']); ?>">
                                                <button type="submit" class="btn btn-warning">Return</button>
                                            </form>
                                        <?php else : ?>                                        
                                            <button class="btn btn-secondary" disabled>Retur Diproses</button>
                                        <?php endif; ?>
                                    <?php } ?>
                                    <a href="tracking_details.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-info">Lacak</a> <!-- New tracking button -->
                                </td>

                            </tr>
                        <?php 
                        $no++; // Untuk pengurutan nomor
                        endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php
ob_end_flush(); // Flush the output buffer
include('templates/footer.php');
?>
