<?php
include('koneksi.php');
include('templates/header.php');

$tracking_number = $_GET['tracking_number'];
$query = "SELECT * FROM bayar WHERE tracking_number = '$tracking_number'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}
?>

<div class="content-wrapper">
    <section class="content">
        <div class="card">
            <div class="card-header">
                Pembayaran Melalui BRI
            </div>
            <div class="card-body">
                <h3>Silakan transfer ke rekening berikut:</h3>
                <p>No. Rekening: 12345678</p>
                <img src="path/to/bri-logo.png" alt="BRI" style="width: 150px; height: auto;">
                <p>Tracking Number: <?= $data['tracking_number']; ?></p>
                <p>Total Pembayaran: Rp. <?= number_format($data['total'], 0, ',', '.'); ?></p>
                <a href="cetak_nota.php?tracking_number=<?= $data['tracking_number']; ?>" class="btn btn-primary">Cetak Nota</a>
            </div>
        </div>
    </section>
</div>

<?php
include('templates/footer.php');
?>
