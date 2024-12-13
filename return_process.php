<?php
ob_start(); // Start output buffering

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('koneksi.php');
include('templates/header.php');
include('templates/sidebar.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bayar_id = $_POST['bayar_id'];
    $id_cart = $_POST['id_cart'];
    $tracking_number = $_POST['tracking_number'];
    $user_id = $_SESSION['user_id'];

    if (isset($_POST['submit'])) {
        $alasan_retur = $_POST['alasan_retur'];

        // Simpan data retur ke database
        $query = "INSERT INTO retur (user_id, bayar_id, id_cart, alasan_retur, tracking_number, status) 
                  VALUES ('$user_id', '$bayar_id', '$id_cart', '$alasan_retur', '$tracking_number', 'RETUR')";
        mysqli_query($koneksi, $query);

        // Update status di tabel bayar
        $update_bayar = "UPDATE bayar SET status = 'RETUR' WHERE id = '$bayar_id'";
        mysqli_query($koneksi, $update_bayar);

        // Redirect ke halaman daftar_retur.php
        header('Location: daftar_retur.php');
        exit();
    }
} else {
    // Jika tidak ada POST request, redirect ke pelacakan.php
    header('Location: pelacakan.php');
    exit();
}

ob_end_flush(); // Flush the output buffer
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Return Item</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <form action="return_process.php" method="post">
                    <input type="hidden" name="bayar_id" value="<?= $bayar_id; ?>">
                    <input type="hidden" name="id_cart" value="<?= $id_cart; ?>">
                    <input type="hidden" name="tracking_number" value="<?= $tracking_number; ?>">

                    <div class="form-group">
                        <label for="alasan_retur">Alasan Retur:</label>
                        <textarea name="alasan_retur" id="alasan_retur" class="form-control" rows="5" required></textarea>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary">Kirim Retur</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php include('templates/footer.php'); ?>
