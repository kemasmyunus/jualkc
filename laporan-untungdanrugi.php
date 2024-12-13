<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>LAPORAN LABA RUGI</title>

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

<body class="A4 landscape">
  <?php
  include('koneksi.php'); // Memanggil file koneksi

  // Menghitung penjualan (total revenue)
  $query_sales = "
    SELECT SUM(price * quantity) AS total_sales
    FROM cart
  ";
  $result_sales = mysqli_query($koneksi, $query_sales) or die(mysqli_error($koneksi));
  $row_sales = mysqli_fetch_assoc($result_sales);
  $total_sales = $row_sales['total_sales'];

  // Menghitung harga pokok penjualan (COGS)
  $query_cogs = "
    SELECT SUM(daftar_barang.harga_beli * daftar_barang.satuan) AS total_cogs
    FROM daftar_barang
  ";
  $result_cogs = mysqli_query($koneksi, $query_cogs) or die(mysqli_error($koneksi));
  $row_cogs = mysqli_fetch_assoc($result_cogs);
  $total_cogs = $row_cogs['total_cogs'];

  // Menghitung laba kotor (gross profit)
  $gross_profit = $total_sales - $total_cogs;

  // Menghitung biaya operasional (operational costs)
  $query_salary_cost = "
    SELECT SUM(gaji) AS total_salary_cost
    FROM karyawan
    WHERE status_aktif = 'aktif'
  ";
  $result_salary_cost = mysqli_query($koneksi, $query_salary_cost) or die(mysqli_error($koneksi));
  $row_salary_cost = mysqli_fetch_assoc($result_salary_cost);
  $total_salary_cost = $row_salary_cost['total_salary_cost'];

  // Menghitung total biaya admin untuk transfer bank
  $query_bank_admin_cost = "
    SELECT COUNT(*) * 3000 AS total_bank_admin_cost
    FROM bayar
    WHERE metode_pembayaran = 'bank_transfer'
  ";
  $result_bank_admin_cost = mysqli_query($koneksi, $query_bank_admin_cost) or die(mysqli_error($koneksi));
  $row_bank_admin_cost = mysqli_fetch_assoc($result_bank_admin_cost);
  $total_bank_admin_cost = $row_bank_admin_cost['total_bank_admin_cost'];

  // Total biaya operasional
  $total_operational_costs = $total_salary_cost + $total_bank_admin_cost;

  // Menghitung laba/rugi bersih (net profit/loss)
  $net_profit = $gross_profit - $total_operational_costs;
  ?>

  <section class="sheet padding-10mm" style="height: auto; font-size: 10px;">
    <img src="assets/img/logo.jpg" style="width: 50px; float: left; margin-right: 10px;" class="text-center">
    <h1 class="text-center" style="margin-bottom: -10px;">TOKO KACAMATA OPTIK GRAND AURA</h1>
    <p class="text-center" style="margin-bottom: 0px;">ALAMAT</p>
    <h3 class="text-center" style="margin-bottom: -10px;">@gmail.com Telp: 0000000000000</h3>
    <p><b>____________________________________________________________________________________________________________________________________________________________________________________________________</b></p>
    <h4 class="text-center">LAPORAN LABA RUGI</h4>
    <hr>

    <table class="table table-bordered" id="example2">
      <thead>
        <tr>
          <th>Keterangan</th>
          <th>Nilai</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Penjualan</td>
          <td>Rp <?= number_format($total_sales, 0, ',', '.'); ?></td>
        </tr>
        <tr>
          <td>Harga Pokok Penjualan</td>
          <td>Rp <?= number_format($total_cogs, 0, ',', '.'); ?></td>
        </tr>
        <tr>
          <td>Laba Kotor</td>
          <td>Rp <?= number_format($gross_profit, 0, ',', '.'); ?></td>
        </tr>
        <tr>
          <td>Biaya Operasional - Gaji</td>
          <td>Rp <?= number_format($total_salary_cost, 0, ',', '.'); ?></td>
        </tr>
        <tr>
          <td>Biaya Operasional - Admin Bank</td>
          <td>Rp <?= number_format($total_bank_admin_cost, 0, ',', '.'); ?></td>
        </tr>
        <tr>
          <td>Total Biaya Operasional</td>
          <td>Rp <?= number_format($total_operational_costs, 0, ',', '.'); ?></td>
        </tr>
        <tr>
          <td>Laba/Rugi Bersih</td>
          <td>Rp <?= number_format($net_profit, 0, ',', '.'); ?></td>
        </tr>
      </tbody>
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
