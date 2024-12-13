<?php
include('templates/header.php');
include('templates/sidebar.php');
include('koneksi.php'); // Ensure the database connection is included

// Fetch items from daftar_barang
$items_query = "SELECT * FROM daftar_barang LIMIT 20"; // Fetch only from daftar_barang
$items = mysqli_query($koneksi, $items_query) or die(mysqli_error($koneksi));

$items = mysqli_fetch_all($items, MYSQLI_ASSOC);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Halaman Beranda</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <?php if ($_SESSION['level'] == 'pelanggan') { ?>
    <section class="content">
      <div class="card" style="padding: 0; margin: 10px;"> <!-- Add margin to the card -->
        <div class="card-body text-center">
          <!-- Slider Container -->
          <div class="slider-container">
            <button class="slider-arrow left-arrow">&lt;</button>
            <div class="slider">
              <?php foreach ($items as $item) { ?>
                <div class="slider-item">
                  <img src="assets/img/<?= htmlspecialchars($item['foto']); ?>" alt="<?= htmlspecialchars($item['nama']); ?>" class="slider-img">
                  <div class="card-body">
                    <h5 class="card-title"><strong><?= htmlspecialchars($item['nama']); ?></strong></h5>
                  </div>
                </div>
              <?php } ?>
            </div>
            <button class="slider-arrow right-arrow">&gt;</button>
          </div>
        </div>
      </div>
    </section>
  <?php } ?>

  <!-- Main content -->
  <?php if ($_SESSION['level'] == 'admin') { ?>
    <!-- Admin Content -->
  <?php } ?>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<style>
.slider-container {
    position: relative;
    width: 100%; /* Changed from 100vw to 100% to keep within the card */
    height: 60vh; /* Adjusted height */
    overflow: hidden;
    margin: 20px auto; /* Added margin to provide space around the slider */
}

.slider {
    display: flex;
    transition: transform 0.5s ease-in-out;
    height: 100%; /* Full height of the container */
}

.slider-item {
    flex: 0 0 33.333%; /* 3 items visible at once */
    box-sizing: border-box;
    padding: 10px;
    text-align: center;
    height: 100%; /* Full height of the slider container */
}

.slider-item img {
    width: auto; /* Maintain original width */
    height: 80%; /* Adjusted height */
    max-height: 60vh; /* Ensure image height fits within the slider container */
    object-fit: cover; /* Cover the slider item area */
}

.left-arrow, .right-arrow {
    position: absolute;
    top: 50%;
    width: 30px; /* Width of the arrow buttons */
    height: 30px; /* Height of the arrow buttons */
    background-color: rgba(0, 0, 0, 0.5); /* Background color */
    color: #fff; /* Arrow color */
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 2;
    transform: translateY(-50%);
    border-radius: 50%; /* Make the arrows circular */
}

.left-arrow {
    left: 10px; /* Position from the left, inside the card */
}

.right-arrow {
    right: 10px; /* Position from the right, inside the card */
}

</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const slider = document.querySelector('.slider');
  const slides = document.querySelectorAll('.slider-item');
  const visibleItems = 3;  // Number of items visible at a time
  const totalSlides = slides.length;
  let index = 0;
  let autoplayInterval;

  function showSlide(n) {
    if (n >= totalSlides - visibleItems + 1) index = 0;  // Loop back to start
    if (n < 0) index = totalSlides - visibleItems;  // Loop to end
    slider.style.transform = `translateX(${-index * (100 / visibleItems)}%)`;
  }

  function startAutoplay() {
    autoplayInterval = setInterval(function() {
      index++;
      showSlide(index);
    }, 2000);
  }

  function stopAutoplay() {
    clearInterval(autoplayInterval);
  }

  document.querySelector('.right-arrow').addEventListener('click', function() {
    index++;
    showSlide(index);
  });

  document.querySelector('.left-arrow').addEventListener('click', function() {
    index--;
    showSlide(index);
  });

  // Start autoplay on page load
  startAutoplay();

  // Stop autoplay when mouse is over the slider and resume when mouse leaves
  slider.addEventListener('mouseover', stopAutoplay);
  slider.addEventListener('mouseout', startAutoplay);
});
</script>

<?php include('templates/footer.php'); ?>
