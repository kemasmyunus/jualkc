<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LAPORAN</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="assets/dist/css/normalize.min.css">
    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="assets/dist/css/paper.css">
    <link rel="stylesheet" href="assets/dist/css/bs.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "" if you need -->
    <style>
        body {
            background-color: #999;
        }

        @page {
            size: A4 landscape
        }

        * {
            font-family: "Arial";
        }

        .text-center {
            text-align: center;
        }

        h1 {
            font-size: 20px;
        }

        h3 {
            font-size: 14px;
            font-weight: normal;
            margin-top: -8px;
        }

        h4 {
            margin-top: 20px;
            text-transform: uppercase;
            margin-bottom: -10px;
        }

        td {
            padding: 5px !important;
            text-align: center;
            vertical-align: middle !important;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4 landscape">
    <?php
    include('koneksi.php'); // Memanggil file koneksi
    $id = $_GET['pelanggan_id']; // Mengambil id pelanggan yang ingin diubah

    // Menampilkan pelanggan berdasarkan id
    $data = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id = '$id'");
    $row_pelanggan = mysqli_fetch_assoc($data);
    ?>
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25- -->
    <section class="sheet padding-10mm" style="height: auto; font-size: 10px;">
        <img src="assets/img/logo.jpg" style="width: 50px; float: left; margin-right: 10px;" class="text-center">
        <h1 class="text-center" style="margin-bottom: -10px;">TOKO KACAMATA OPTIK GRAND AURA</h1>
        <p class="text-center" style="margin-bottom: 0px;">XXXXXXXXXXXXXX</p>
        <h3 class="text-center" style="margin-bottom: -10px;">auraoptik@gmail.com Telp: 081234567</h3>
        <p><b>____________________________________________________________________________________________________________________________________________________________________________________________________</b></p>
        <h4 class="text-center">LAPORAN HISTORY PELANGGAN : <?= $row_pelanggan['nama']; ?></h4>
        <hr>

        <table class="table table-bordered" id="example2">
            <thead>
                <tr>
                    <th colspan="4">Data Pelanggan</th>
                </tr>
                <tr>
                    <th>Nama: <?= $row_pelanggan['nama']; ?></th>
                    <th>No Hp: <?= $row_pelanggan['hp']; ?></th>
                    <th>Alamat: <?= $row_pelanggan['alamat']; ?></th>
                </tr>
            </thead>
        </table>
        <hr>
        <table class="table table-bordered" id="example2">
            <thead>
                <tr colspan="6">
                    <th>History Pembelian Barang</th>
                </tr>
                <tr style="white-space: nowrap !important;">
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Ukuran</th>
                    <th>Warna</th>
                    <th>Jumlah</th>
                    <th>Gambar</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menggabungkan tabel cart dan pelanggan untuk mengambil data history pembelian
                $query = "
                    SELECT cart.*, pelanggan.nama AS nama_pelanggan 
                    FROM cart
                    JOIN pelanggan ON cart.user_id = pelanggan.id
                    WHERE cart.user_id = '$id'
                ";
                $datas = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

                $no = 1; // Untuk pengurutan nomor
                $total_harga = 0; // Inisialisasi total harga

                // Melakukan perulangan untuk menampilkan data
                while ($row = mysqli_fetch_assoc($datas)) {
                    $total_harga += $row['price'] * $row['quantity']; // Menghitung total harga
                ?>

                    <tr style="white-space: nowrap !important;">
                        <td><?= $no; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['ukuran']; ?></td>
                        <td><?= $row['warna']; ?></td>
                        <td><?= $row['quantity']; ?></td>
                        <td><img src="assets/img/<?= $row['image']; ?>" width="50"></td>
                        <td>Rp <?= number_format($row['price'], 0, ',', '.'); ?></td>
                    </tr>

                <?php $no++;
                } ?>
            </tbody>
        </table>
        <table class="table table-bordered" style="margin-top: 10px;">
            <thead>
                <tr>
                    <th style="text-align: right;">Total Harga</th>
                    <th style="text-align: right;">Rp <?= number_format($total_harga, 0, ',', '.'); ?></th>
                </tr>
            </thead>
        </table>

        <table style="width: 200px; font-size: 11px; float: right; margin-top: 60px;">
            <tr>
                <th colspan="2">BANJARMASIN, <?= date('d-m-Y'); ?></th>
            </tr>
            <tr style="height: 100px;">
                <td style="width: 50%"></td>
            </tr>
            <tr>
                <td>
                    <span style="text-decoration: underline;">
                        <?php
                        $data_ttd = mysqli_query($koneksi, "SELECT * FROM pengaturan WHERE id = '1'");
                        $row_ttd = mysqli_fetch_assoc($data_ttd);
                        ?>
                        <?= $row_ttd['ttd']; ?>
                    </span>
                    <br>
                </td>
            </tr>
        </table>
    </section>
    <script>
        window.print();
    </script>
</body>

</html>