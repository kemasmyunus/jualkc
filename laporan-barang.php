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

  include('koneksi.php'); //memanggil file koneksi

  ?>
  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25- -->
  <section class="sheet padding-10mm" style="height: auto;font-size: 10px;">
    <img src="assets/img/logo.jpg" style="width: 50px;float: left;margin-right: 10px;" class="text-center">
    <h1 class="text-center" style="margin-bottom: -10px;">TOKO KACAMATA OPTIK GRAND AURA</h1>
    <p class="text-center" style="margin-bottom: 0px;">ALAMAT</p>
    <h3 class="text-center" style="margin-bottom: -10px;">@gmail.com Telp: 0000000000000</h3>
    <p><b>____________________________________________________________________________________________________________________________________________________________________________________________________</b></p>
    <h4 class="text-center">LAPORAN DATA BARANG </h4>
    <hr>

    <table class="table table-bordered" id="example2">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Harga Beli</th>
          <th>Harga Bual</th>
          <th>Stok</th>
          <th>Merek</th>
          <th>Gambar</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $datas = mysqli_query($koneksi, "SELECT * FROM daftar_barang") or die(mysqli_error($koneksi));

        $no = 1; //untuk pengurutan nomor

        //melakukan perulangan
        while ($row = mysqli_fetch_assoc($datas)) {
        ?>

          <tr>
            <td><?= $no; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['harga_jual']; ?></td>
            <td><?= $row['harga_beli']; ?></td>
            <td><?= $row['satuan']; ?></td>
            <td><?= $row['merek']; ?></td>
            <td><?= $row['foto']; ?></td>
          </tr>

        <?php $no++;
        } ?>
      </tbody>
    </table>
    <table style="width: 200px;font-size: 11px;float:right;margin-top: 60px;">
      <tr>
        <th colspan="2">BANJARMASIN, <?= format_tanggal(date('Y-m-d')); ?></th>
      </tr>
      <tr style="height: 100px;">
        <td style="width: 50%">

        </td>
      </tr>
      <tr>
        <td>
          <span style="text-decoration: underline;">
            <?php $data_ttd   = mysqli_query($koneksi, "select * from pengaturan where id = '1'");
            $row_ttd  = mysqli_fetch_assoc($data_ttd);
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