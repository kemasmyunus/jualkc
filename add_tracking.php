<?php
ob_start();
include('koneksi.php');
include('templates/header.php');
include('templates/sidebar.php');
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bayar_id = intval($_POST['bayar_id']);
    $status = $_POST['status'];
    $coordinates = $_POST['coordinates'];

    $query = "INSERT INTO tracking (bayar_id, status, coordinates) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'iss', $bayar_id, $status, $coordinates);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: pelacakan.php');
        ob_end_flush();
        exit;
    } else {
        die('Error adding tracking information: ' . mysqli_error($koneksi));
    }
}

// Fetch the `bayar` records for the form
$query = "SELECT * FROM bayar";
$result = mysqli_query($koneksi, $query);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Tambah Proses Tracking</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="bayar_id">Pilih Pesanan</label>
                        <select name="bayar_id" id="bayar_id" class="form-control" required>
                            <option value="">-- Pilih Pesanan --</option>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['tracking_number']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status Proses</label>
                        <input type="text" name="status" id="status" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="coordinates">Koordinat (latitude,longitude)</label>
                        <input type="text" name="coordinates" id="coordinates" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Proses</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php
ob_end_flush();
include('templates/footer.php');
?>
