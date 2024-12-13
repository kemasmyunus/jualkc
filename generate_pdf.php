<?php
// Menampilkan semua error
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('fpdf.php'); // Pastikan file ini tersedia
include('koneksi.php'); // Pastikan koneksi terhubung

// Cek apakah parameter tracking_number ada
if (!isset($_GET['tracking_number'])) {
    die("Nomor pelacakan tidak disediakan!");
}

$tracking_number = $_GET['tracking_number'];

// Query untuk mendapatkan detail pesanan berdasarkan tracking_number
$query = "SELECT * FROM bayar WHERE tracking_number='$tracking_number'";
$result = mysqli_query($koneksi, $query);

// Cek apakah ada data yang ditemukan
if (mysqli_num_rows($result) == 0) {
    die("Pesanan tidak ditemukan!");
}

$order = mysqli_fetch_assoc($result);

// Pastikan setiap field yang digunakan tidak null
if (!$order) {
    die("Tidak ada data pesanan yang ditemukan!");
}

// Membuat PDF menggunakan FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Judul Nota/Resi
$pdf->SetFont('Arial', 'B', 16); // Menggunakan font Arial, font default yang ada
$pdf->Cell(0, 10, 'Nota / Resi Pesanan', 0, 1, 'C');
$pdf->Ln(10);

// Detail Pesanan
$pdf->SetFont('Arial', '', 12); // Menggunakan font Arial untuk isi

// Pengecekan null pada setiap field
$pdf->Cell(50, 10, 'Nomor Pelacakan:', 0, 0);
$pdf->Cell(100, 10, isset($order['tracking_number']) ? $order['tracking_number'] : 'N/A', 0, 1);

$pdf->Cell(50, 10, 'Nama Lengkap:', 0, 0);
$pdf->Cell(100, 10, isset($order['nama_lengkap']) ? $order['nama_lengkap'] : 'N/A', 0, 1);

$pdf->Cell(50, 10, 'Alamat:', 0, 0);
$pdf->MultiCell(100, 10, isset($order['alamat']) ? $order['alamat'] : 'N/A');

$pdf->Cell(50, 10, 'Telepon:', 0, 0);
$pdf->Cell(100, 10, isset($order['telepon']) ? $order['telepon'] : 'N/A', 0, 1);

$pdf->Cell(50, 10, 'Metode Pembayaran:', 0, 0);
$pdf->Cell(100, 10, isset($order['metode_pembayaran']) ? $order['metode_pembayaran'] : 'N/A', 0, 1);

$pdf->Cell(50, 10, 'Status:', 0, 0);
$pdf->Cell(100, 10, isset($order['status']) ? $order['status'] : 'N/A', 0, 1);

$pdf->Ln(20);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Terima Kasih Telah Berbelanja!', 0, 1, 'C');

// Output PDF ke browser
$pdf->Output('I', 'Nota_Resi_' . (isset($order['tracking_number']) ? $order['tracking_number'] : 'unknown') . '.pdf');
?>
