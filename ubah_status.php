<?php
include('koneksi.php');
include('templates/header.php');
include('templates/sidebar.php');

// Query untuk mendapatkan semua tracking number
$tracking_numbers_query = "SELECT tracking_number, metode_pembayaran, bukti_transfer FROM bayar";
$tracking_numbers_result = mysqli_query($koneksi, $tracking_numbers_query);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ubah Status Pembayaran</h1>
                </div>
            </div>
        </div>
    </section>

    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'success'): ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($_GET['message']); ?>
            </div>
        <?php elseif ($_GET['status'] == 'error'): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="proses_ubah_status.php">
                    <div class="form-group">
                        <label for="tracking_number">Kode Pengiriman:</label>
                        <select class="form-control" name="tracking_number" id="tracking_number" required>
                            <option value="">Pilih Kode Pengiriman</option>
                            <?php while ($row = mysqli_fetch_assoc($tracking_numbers_result)): ?>
                                <option value="<?= htmlspecialchars($row['tracking_number']); ?>" data-metode="<?= htmlspecialchars($row['metode_pembayaran']); ?>" data-bukti="<?= htmlspecialchars($row['bukti_transfer']); ?>">
                                    <?= htmlspecialchars($row['tracking_number']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div id="bukti_transfer_preview" style="display: none; margin-top: 20px;">
                        <p><strong>Bukti Transfer:</strong></p>
                        <img id="bukti_image" src="" alt="Bukti Transfer" style="max-width: 100%; height: auto; border: 1px solid #ccc; padding: 5px;">
                    </div>
                    <div class="form-group">
                        <label for="keterangan_pembayaran">Keterangan Pembayaran:</label>
                        <select class="form-control" name="keterangan_pembayaran" id="keterangan_pembayaran" required>
                            <option value="sudah dibayar">Sudah Dibayar</option>
                            <option value="belum dibayar">Belum Dibayar</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Ubah Status</button>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
    document.getElementById('tracking_number').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var buktiPath = selectedOption.getAttribute('data-bukti');

        if (buktiPath) {
            document.getElementById('bukti_transfer_preview').style.display = 'block';
            document.getElementById('bukti_image').src = 'uploads/' + buktiPath;
        } else {
            document.getElementById('bukti_transfer_preview').style.display = 'none';
            document.getElementById('bukti_image').src = '';
        }
    });
</script>

<?php
include('templates/footer.php');
?>
