<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Feedback</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    .star-rating .fa-star {
      font-size: 24px;
      color: #ddd;
      cursor: pointer;
    }

    .star-rating .fa-star.checked {
      color: #ffc107;
    }
  </style>
</head>

<body>
  <?php include('templates/header.php'); ?>
  <?php include('templates/sidebar.php'); ?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Halaman Tambah Feedback</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php if ($_SESSION['level'] == 'pelanggan') { ?>
      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Tambah Feedback</h3>
          </div>
          <div class="card-body">
            <form action="" method="post" role="form">
              <div class="form-group">
                <label>Nama Barang</label>
                <select name="nama" required="" class="form-control">
                  <option value="">Pilih Kacamata</option>
                  <?php
                  include('koneksi.php');
                  // Fetch technicians from the karyawan table
                  $result = mysqli_query($koneksi, "SELECT id, nama FROM daftar_barang");
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['nama']}'>{$row['nama']}</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label>Rating</label>
                <div class="star-rating">
                  <span class="fa fa-star" data-rating="1"></span>
                  <span class="fa fa-star" data-rating="2"></span>
                  <span class="fa fa-star" data-rating="3"></span>
                  <span class="fa fa-star" data-rating="4"></span>
                  <span class="fa fa-star" data-rating="5"></span>
                  <input type="hidden" name="rating" class="rating-value" required="">
                </div>
              </div>
              <div class="form-group">
                <label>Komentar</label>
                <textarea name="komentar" required="" class="form-control"></textarea>
              </div>
              <button type="submit" class="btn btn-primary" name="submit" value="simpan">Simpan Feedback</button>
            </form>
          </div>
        </div>

      </section>
    <?php } ?>
    <?php if ($_SESSION['level'] == 'admin') { ?>
      <!-- Main content -->
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Feedback</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>nama Barang</th>
                  <th>Rating</th>
                  <th>Komentar</th>
                </tr>
              </thead>
              <tbody>
                <?php
                include('koneksi.php');
                $sql = "SELECT feedback.id, daftar_barang.nama, feedback.rating, feedback.komentar 
                                    FROM feedback 
                                    JOIN daftar_barang  ON feedback.nama = daftar_barang.nama";
                $result = mysqli_query($koneksi, $sql);
                if ($result) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                                            <td>{$row['id']}</td>       
                                            <td>{$row['nama']}</td>
                                            <td>{$row['rating']}</td>
                                            <td>{$row['komentar']}</td>
                                        </tr>";
                  }
                } else {
                  echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </section>
    <?php } ?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('templates/footer.php'); ?>

  <script>
    document.addEventListener('DOMContentLoaded', (event) => {
      const stars = document.querySelectorAll('.star-rating .fa-star');
      const ratingValue = document.querySelector('.rating-value');

      stars.forEach(star => {
        star.addEventListener('click', () => {
          const rating = star.getAttribute('data-rating');
          ratingValue.value = rating;
          stars.forEach(s => {
            if (s.getAttribute('data-rating') <= rating) {
              s.classList.add('checked');
            } else {
              s.classList.remove('checked');
            }
          });
        });
      });
    });
  </script>

  <?php
  if (isset($_POST['submit'])) {
    //menampung data dari inputan
    $nama = $_POST['nama'];
    $rating = $_POST['rating'];
    $komentar = $_POST['komentar'];

    // Insert data into the feedback table
    $datas = mysqli_query($koneksi, "INSERT INTO feedback (nama, rating, komentar) VALUES ('$nama', '$rating', '$komentar')") or die(mysqli_error($koneksi));

    echo "<script>alert('terima kasih untuk saran nya.');window.location='feedback_index.php';</script>";
  }
  ?>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>