<?php
include('koneksi.php');
include('templates/header.php');
include('templates/sidebar.php');

// Asumsikan user_id disimpan di sesi setelah pengguna login
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Jika tidak ada user_id di sesi, arahkan pengguna ke halaman login
    header('Location: login.php');
    exit;
}

// Ambil data dari keranjang belanja
$select_cart = mysqli_query($koneksi, "SELECT * FROM `cart` WHERE user_id = $user_id") or die('query failed');
$grand_total = 0;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Periksa</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Checkout Form -->
        <div class="card">
            <div class="card-body">
                <form action="checkout.php" method="post" id="checkoutForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Ringkasan Belanja -->
                            <div class="card">
                                <div class="card-header">
                                    Ringkasan Belanja
                                </div>
                                <div class="card-body">
                                    <?php while ($fetch_cart = mysqli_fetch_assoc($select_cart)) : ?>
                                        <p><?= $fetch_cart['name']; ?> (<?= $fetch_cart['quantity']; ?> x Rp. <?= number_format($fetch_cart['price'], 0, ',', '.'); ?>)</p>
                                        <?php $sub_total = $fetch_cart['quantity'] * $fetch_cart['price']; ?>
                                        <?php $grand_total += $sub_total; ?>
                                    <?php endwhile; ?>
                                </div>
                                <div class="card-footer">
                                    <strong>Total Belanja: Rp. <?= number_format($grand_total, 0, ',', '.'); ?> /-</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- Informasi Pengiriman -->
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama_lengkap" value="<?= $_SESSION['nama']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat Pengiriman</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= $_SESSION['user_alamat']; ?> </textarea>
                        </div>
                        <div class="form-group">
                            <label for="telepon">Nomor Telepon</label>
                            <input type="text" class="form-control" id="telepon" name="telepon" value="<?= $_SESSION['user_hp'];?>"required>
                        </div>
                        <div class="form-group">
                            <label>Metode Pengiriman</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="metode_pengiriman" id="reguler" value="reguler" required>
                                <label class="form-check-label" for="reguler">Reguler</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="metode_pengiriman" id="ekspres" value="ekspres">
                                <label class="form-check-label" for="ekspres">Ekspres</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="metode_pengiriman" id="sameday" value="same day">
                                <label class="form-check-label" for="sameday">Same Day</label>
                            </div>
                        </div>
                        <!-- Opsi Pembayaran -->
                        <div class="form-group">
                            <label>Metode Pembayaran</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="metode_pembayaran" id="bank_transfer" value="bank_transfer" required>
                                <label class="form-check-label" for="bank_transfer">Transfer Bank</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="metode_pembayaran" id="e_wallet" value="e_wallet">
                                <label class="form-check-label" for="e_wallet">E-wallet</label>
                            </div>
                        </div>

                        <!-- Detail Pembayaran berdasarkan pilihan -->
                        <div class="form-group" id="bankTransferField" style="display: none;">
                            <!-- Pilihan Bank -->
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="bank" id="bri" value="bri">
                                <label class="form-check-label" for="bri">
                                    <img src="assets/img/bri.png" alt="BRI" style="width: auto; height: 40px;"> no rekening : 42512421
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="bank" id="bca" value="bca">
                                <label class="form-check-label" for="bca">
                                    <img src="assets/img/bca.png" alt="BCA" style="width: auto; height: 23px;"> no rekening : 09172421
                                </label>
                            </div>

                            <!-- Pemberitahuan biaya admin -->
                            <p class="text-warning mt-2">Perlu diketahui bahwa setiap transaksi menggunakan transfer bank akan dikenakan biaya admin sebesar Rp. 3000.</p>
                        </div>

                        <div class="form-group" id="ewalletField" style="display: none;">

                            <!-- Pilihan E-Wallet -->
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ewallet" id="dana" value="dana">
                                <label class="form-check-label" for="dana">
                                    <img src="assets/img/dana.png" alt="Dana" style="width: auto; height: 30px;"> 
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ewallet" id="shopeepay" value="shopeepay">
                                <label class="form-check-label" for="shopeepay">
                                    <img src="assets/img/shopeepay.png" alt="ShopeePay" style="width: auto; height: 40px;"> 
                                </label>
                            </div>

                            <!-- Pemberitahuan biaya admin -->
                            <p class="text-warning mt-2">Perlu diketahui bahwa setiap transaksi menggunakan transfer bank akan dikenakan biaya admin sebesar Rp. 3000.</p>
                        </div>

                    </div>

                    <!-- Tombol Submit -->
                    <div class="form-group mt-3">
                        <button type="submit" name="submit" class="btn btn-primary">Proses Checkout</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<?php
if (isset($_POST['submit'])) {
// Menampung data dari inputan
$nama_lengkap = $_POST['nama_lengkap'];
$alamat = $_POST['alamat'];
$telepon = $_POST['telepon'];
$metode_pembayaran = $_POST['metode_pembayaran'];
$no_e_wallet = isset($_POST['no_e_wallet']) ? $_POST['no_e_wallet'] : '';
$no_rekening = isset($_POST['no_rekening']) ? $_POST['no_rekening'] : '';
$no_kartu_kredit = isset($_POST['no_kartu_kredit']) ? $_POST['no_kartu_kredit'] : '';
$nama_pemegang_kartu = isset($_POST['nama_pemilik']) ? $_POST['nama_pemilik'] : '';
$metode_pengiriman = isset($_POST['metode_pengiriman']) ? $_POST['metode_pengiriman'] : '';
$tanggal_kadaluarsa = isset($_POST['tanggal_kadaluarsa']) ? $_POST['tanggal_kadaluarsa'] : '';
$kode_cvc = isset($_POST['cvc']) ? $_POST['cvc'] : '';
$bukti_transfer = '';

// Mendapatkan nama bank atau e-wallet yang dipilih
$nama_bank = isset($_POST['bank']) ? $_POST['bank'] : NULL; // Untuk BRI/BCA
$nama_ewallet = isset($_POST['ewallet']) ? $_POST['ewallet'] : NULL; // Untuk Dana/ShopeePay

// Proses upload bukti transfer jika ada
if ($_FILES['bukti_transfer']['name']) {
    $uploadDir = 'uploads/';
    $fileName = basename($_FILES['bukti_transfer']['name']);
    $targetFilePath = $uploadDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Memeriksa apakah file yang diunggah adalah gambar
    $allowTypes = array('jpg', 'jpeg', 'png');
    if (in_array($fileType, $allowTypes)) {
        // Upload file ke server
        if (move_uploaded_file($_FILES['bukti_transfer']['tmp_name'], $targetFilePath)) {
            $bukti_transfer = $fileName;
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "File harus berupa gambar (jpg, jpeg, png).";
    }
}

// Generate a unique tracking number
$tracking_number = uniqid('SEN-');

// Ambil data cart yang sesuai dengan user_id
$select_cart = mysqli_query($koneksi, "SELECT * FROM `cart` WHERE user_id = $user_id") or die('query failed');

// Simpan ke dalam tabel bayar
while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
    $id_cart = $fetch_cart['id'];

    $query = "INSERT INTO bayar (user_id, id_cart, nama_lengkap, alamat, telepon, metode_pembayaran, no_e_wallet, no_rekening, no_kartu_kredit, nama_pemegang_kartu, tanggal_kadaluarsa, kode_cvc, bukti_transfer, tracking_number, metode_pengiriman, nama_bank, nama_ewallet)
              VALUES ('$user_id', '$id_cart', '$nama_lengkap', '$alamat', '$telepon', '$metode_pembayaran', '$no_e_wallet', '$no_rekening', '$no_kartu_kredit', '$nama_pemegang_kartu', '$tanggal_kadaluarsa', '$kode_cvc', '$bukti_transfer', '$tracking_number', '$metode_pengiriman', '$nama_bank', '$nama_ewallet')";

    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        echo "Error: " . mysqli_error($koneksi);
    }
}

// Redirect to track page
echo "<script>alert('Data berhasil disimpan.');window.location='track.php?tracking_number=$tracking_number';</script>";

}
?>

<!-- JavaScript untuk menampilkan input sesuai metode pembayaran yang dipilih -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var bankTransferField = document.getElementById('bankTransferField');
        var ewalletField = document.getElementById('ewalletField');
        var qrisField = document.getElementById('qrisField');
        var kartuKreditField = document.getElementById('kartuKreditField');

        var bankTransferRadio = document.getElementById('bank_transfer');
        var ewalletRadio = document.getElementById('e_wallet');
        var qrisRadio = document.getElementById('qris');
        var kartuKreditRadio = document.getElementById('kartu_kredit');

        bankTransferRadio.addEventListener('change', function() {
            if (bankTransferRadio.checked) {
                bankTransferField.style.display = 'block';
                ewalletField.style.display = 'none';
                qrisField.style.display = 'none';
                kartuKreditField.style.display = 'none';
            }
        });

        ewalletRadio.addEventListener('change', function() {
            if (ewalletRadio.checked) {
                bankTransferField.style.display = 'none';
                ewalletField.style.display = 'block';
                qrisField.style.display = 'none';
                kartuKreditField.style.display = 'none';
            }
        });

        qrisRadio.addEventListener('change', function() {
            if (qrisRadio.checked) {
                bankTransferField.style.display = 'none';
                ewalletField.style.display = 'none';
                qrisField.style.display = 'block';
                kartuKreditField.style.display = 'none';
            }
        });

        kartuKreditRadio.addEventListener('change', function() {
            if (kartuKreditRadio.checked) {
                bankTransferField.style.display = 'none';
                ewalletField.style.display = 'none';
                qrisField.style.display = 'none';
                kartuKreditField.style.display = 'block';
            }
        });
    });
</script>

<?php
include('templates/footer.php');
?>
