<?php
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tracking_number = mysqli_real_escape_string($koneksi, $_POST['tracking_number']);
    $keterangan_pembayaran = mysqli_real_escape_string($koneksi, $_POST['keterangan_pembayaran']);

    // Validasi data
    if (!empty($tracking_number) && !empty($keterangan_pembayaran)) {
        $update_query = "UPDATE bayar SET keterangan_pembayaran = '$keterangan_pembayaran' WHERE tracking_number = '$tracking_number'";
        if (mysqli_query($koneksi, $update_query)) {
            // Redirect ke halaman ubah_status.php dengan pesan sukses
            $message = "Status pembayaran untuk Kode Pengiriman $tracking_number berhasil diubah menjadi '$keterangan_pembayaran'.";
            header("Location: ubah_status.php?status=success&message=" . urlencode($message));
            exit();
        } else {
            // Redirect ke halaman ubah_status.php dengan pesan error
            $error_message = "Gagal mengubah status pembayaran: " . mysqli_error($koneksi);
            header("Location: ubah_status.php?status=error&message=" . urlencode($error_message));
            exit();
        }
    } else {
        // Redirect ke halaman ubah_status.php dengan pesan error karena input tidak valid
        header("Location: ubah_status.php?status=error&message=" . urlencode("Harap pilih kode pengiriman dan keterangan pembayaran."));
        exit();
    }
}
?>
