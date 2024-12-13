<?php
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tracking_number = $_POST['tracking_number'];

    // Cek apakah file diunggah
    if (isset($_FILES['bukti_transfer']) && $_FILES['bukti_transfer']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['bukti_transfer']['tmp_name'];
        $file_name = basename($_FILES['bukti_transfer']['name']);
        $upload_dir = 'uploads/';
        
        // Pastikan direktori upload ada
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Tentukan path lengkap untuk menyimpan file
        $file_path = $upload_dir . $file_name;

        // Pindahkan file ke direktori tujuan
        if (move_uploaded_file($file_tmp, $file_path)) {
            // Simpan informasi file ke database
            $query = "UPDATE bayar SET bukti_transfer='$file_name' WHERE tracking_number='$tracking_number'";
            if (mysqli_query($koneksi, $query)) {
                // Redirect dengan parameter query untuk menunjukkan hasil sukses
                header("Location: track.php?tracking_number=$tracking_number&status=success");
                exit;
            } else {
                // Redirect dengan parameter query untuk menunjukkan kesalahan saat menyimpan data
                header("Location: track.php?tracking_number=$tracking_number&status=db_error");
                exit;
            }
        } else {
            // Redirect dengan parameter query untuk menunjukkan kesalahan saat mengunggah file
            header("Location: track.php?tracking_number=$tracking_number&status=upload_error");
            exit;
        }
    } else {
        // Redirect dengan parameter query untuk menunjukkan bahwa file tidak valid
        header("Location: track.php?tracking_number=$tracking_number&status=invalid_file");
        exit;
    }
} else {
    // Redirect dengan parameter query untuk menunjukkan bahwa metode request tidak valid
    header("Location: track.php?status=invalid_request");
    exit;
}
?>
