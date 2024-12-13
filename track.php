<?php
include('koneksi.php');
include('templates/header.php');
include('templates/sidebar.php');

// Get the tracking number from the URL
if (isset($_GET['tracking_number'])) {
    $tracking_number = $_GET['tracking_number'];

    // Query to fetch order details based on the tracking number
    $query = "SELECT * FROM bayar WHERE tracking_number='$tracking_number'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result);

        // Set default style and logo
        $background_color = '#f8f9fa'; // Default color
        $logo = '';

        // Check nama_bank or nama_ewallet to set styles and logos
        if ($order['nama_bank'] === 'bri') {
            $background_color = '#0a4591'; // BRI blue color
            $logo = 'bri.png';
        } elseif ($order['nama_bank'] === 'bca') {
            $background_color = '#003399'; // BCA blue color
            $logo = 'bca.png';
        } elseif ($order['nama_ewallet'] === 'dana') {
            $background_color = '#0176e9'; // Dana blue color
            $logo = 'dana.png';
        } elseif ($order['nama_ewallet'] === 'shopeepay') {
            $background_color = '#f94f4b'; // ShopeePay red color
            $logo = 'shopeepay.png';
        }
    } else {
        echo "<p>Nomor pelacakan tidak valid. Silakan periksa lagi.</p>";
        exit;
    }
} else {
    echo "<p>Tidak ada nomor pelacakan yang disediakan.</p>";
    exit;
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: <?= $background_color; ?>;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pelacakan Pesanan</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Order Details -->
        <div class="card">
            <div class="card-body">
                <?php if ($logo): ?>
                    <div class="logo">
                        <img src="assets/img/<?= $logo; ?>" alt="Logo" style="width: 100px;">
                    </div>
                <?php endif; ?>

                <h3>Detail Pesanan</h3>
                <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($order['nama_lengkap']); ?></p>
                <p><strong>Alamat:</strong> <?= htmlspecialchars($order['alamat']); ?></p>
                <p><strong>Nomor Telepon:</strong> <?= htmlspecialchars($order['telepon']); ?></p>
                <p><strong>Metode Pembayaran:</strong> <?= htmlspecialchars($order['metode_pembayaran']); ?></p>
                <p><strong>Kode Pengiriman:</strong> <?= htmlspecialchars($order['tracking_number']); ?></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($order['status']); ?></p>
                <p><strong>Keterangan Pembayaran:</strong> <?= htmlspecialchars($order['keterangan_pembayaran']); ?></p>
                <!-- Kondisi untuk menampilkan upload bukti transfer hanya jika nama_bank tidak null -->
                <?php if (!empty($order['nama_bank'])): ?>
                    <label for="bukti_transfer">Upload Bukti Transfer</label>
                    <form action="upload_bukti_transfer.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="tracking_number" value="<?= htmlspecialchars($order['tracking_number']); ?>">
                        <input type="file" class="form-control-file" id="bukti_transfer" name="bukti_transfer" required>
                        <button type="submit" class="btn btn-success mt-2">Upload</button>
                    </form>
                <?php endif; ?>
                <?php
                if (isset($_GET['status'])) {
                    switch ($_GET['status']) {
                        case 'success':
                            echo "<p class='alert alert-success'>Bukti transfer berhasil diunggah.</p>";
                            break;
                        case 'db_error':
                            echo "<p class='alert alert-danger'>Terjadi kesalahan saat menyimpan data ke database.</p>";
                            break;
                        case 'upload_error':
                            echo "<p class='alert alert-danger'>Terjadi kesalahan saat mengunggah file.</p>";
                            break;
                        case 'invalid_file':
                            echo "<p class='alert alert-warning'>Harap unggah file yang valid.</p>";
                            break;
                        case 'invalid_request':
                            echo "<p class='alert alert-danger'>Metode request tidak valid.</p>";
                            break;
                    }
                }
                ?>


                <!-- Tombol Lanjut Belanja -->
                <!-- di e walet tidak pakai upload bukti transfer, pakai ifelse
                buat upload bukti transfer bisa dilihat admin 
                -->
                <div class="mt-4">
                    <a href="jual.php" class="btn btn-primary">Lanjut Belanja</a>
                </div>
                
            </div>
        </div>
    </section>
</div>

<?php
include('templates/footer.php');
?>
