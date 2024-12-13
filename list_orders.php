<?php
include('koneksi.php');
include('templates/header.php');
include('templates/sidebar.php');

// Mulai sesi
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, redirect ke halaman login atau tampilkan pesan
    header('Location: login.php');
    exit();
}

// Ambil ID pengguna dari sesi
$user_id = $_SESSION['user_id'];

// Query untuk mendapatkan daftar pesanan hanya untuk pengguna yang login
$query = "SELECT tracking_number, nama_lengkap, alamat, telepon, metode_pembayaran, status FROM bayar WHERE user_id = '$user_id' ORDER BY tracking_number DESC";
$result = mysqli_query($koneksi, $query);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daftar Pesanan</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nomor Pelacakan</th>
                            <th>Nama Lengkap</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Metode Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($order = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['tracking_number']); ?></td>
                            <td><?= htmlspecialchars($order['nama_lengkap']); ?></td>
                            <td><?= htmlspecialchars($order['alamat']); ?></td>
                            <td><?= htmlspecialchars($order['telepon']); ?></td>
                            <td><?= htmlspecialchars($order['metode_pembayaran']); ?></td>
                            <td><?= htmlspecialchars($order['status']); ?></td>
                            <td>
                                <!-- Link untuk mencetak nota atau resi dalam bentuk PDF -->
                                <a href="generate_pdf.php?tracking_number=<?= urlencode($order['tracking_number']); ?>" target="_blank" class="btn btn-primary">Cetak Nota / Resi</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php
include('templates/footer.php');
?>
