  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #F44336 !important;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link text-center" style="border-color: transparent;">
      <span class="brand-text font-white-light" style="font-size: 14px;">TOKO OPTIK GRAND AURA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex ">
        <div class="info">
          <a href="#" class="d-block text-white">Selamat datang <?= $_SESSION['nama']; ?> </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <?php if ($_SESSION['level'] == 'pelanggan') { ?>
              <li class="nav-item">
            <a href="index-pelanggan.php" class="nav-link text-white">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
            <?php } ?>
               <?php if ($_SESSION['level'] == 'admin') { ?>
                <li class="nav-item">
                  <a href="index.php" class="nav-link text-white">
                    <i class="nav-icon fas fa-home"></i>
                    <p>
                      Dashboard
                    </p>
                  </a>
                </li>
                <li class="nav-item">
  <a href="ubah_status.php" class="nav-link text-white">
    <i class="nav-icon fas fa-edit"></i> <!-- Mengubah ikon menjadi "edit" -->
    <p>
      Edit Status
    </p>
  </a>
</li>
<li class="nav-item">
  <a href="add_tracking.php" class="nav-link text-white">
    <i class="nav-icon fas fa-map"></i> <!-- Mengubah ikon menjadi "map" -->
    <p>
      Tracking
    </p>
  </a>
</li>

                <li class="nav-item">
              <a href="#" class="nav-link text-white">
                <i class="nav-icon fas fa-folder"></i>
                <p>
                  Data Master
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview " style="display: none;">
                <li class="nav-item">
                  <a href="karyawan-index.php" class="nav-link text-white">
                    <i class="far fa-folder nav-icon"></i>
                    <p>Data karyawan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pelanggan-index.php" class="nav-link text-white">
                    <i class="far fa-folder nav-icon"></i>
                    <p>Data Pelanggan</p>
                  </a>
                </li>


                <li class="nav-item">
                  <a href="stok-index.php" class="nav-link text-white">
                    <i class="far fa-folder nav-icon"></i>
                    <p>Daftar Barang</p>
                  </a>
                </li>

              </ul>
            </li>
          <?php } ?>




          <?php if (($_SESSION['level'] == 'admin') || ($_SESSION['level'] == 'pelanggan')) { ?>
            <li class="nav-item">
              <a href="#" class="nav-link text-white">
                <i class="nav-icon fas fa-folder"></i>
                <p>
                  Konsultasi
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview " style="display: none;">
                <li class="nav-item">
                  <a href="konsul.php" class="nav-link text-white">
                    <i class="far fa-folder nav-icon"></i>
                    <p>Konsultasi Toko</p>
                  </a>
                </li>
                <?php if ($_SESSION['level'] == 'pelanggan') { ?>
                <li class="nav-item">
                  <a href="konsul-dokter.php" class="nav-link text-white">
                    <i class="far fa-folder nav-icon"></i>
                    <p>Konsultasi Dokter</p>
                  </a>
                </li>
                <?php } ?>
                <?php if ($_SESSION['level'] == 'admin') { ?>
                <li class="nav-item">
                  <a href="rekomendasi.php" class="nav-link text-white">
                    <i class="far fa-folder nav-icon"></i>
                    <p>Rekomendasi Barang</p>
                  </a>
                </li>
                <?php } ?>

              </ul>
            </li>
          <?php } ?>


            <?php if ($_SESSION['level'] == 'pelanggan') { ?>
              <li class="nav-item">
                <a href="jual.php" class="nav-link text-white">
                  <i class="nav-icon fas fa-folder"></i>
                  <p>
                    Pembelian Kacamata
                  </p>
                </a>
              </li>
            <?php } ?>
            <?php if ($_SESSION['level'] == 'admin') { ?>
              <li class="nav-item">
                <a href="barang.php" class="nav-link text-white">
                  <i class="nav-icon fas fa-shopping-cart"></i>
                  <p>
                    Barang terjual
                  </p>
                </a>
              </li>
            <?php } ?>
            <?php if ($_SESSION['level'] == 'pelanggan') { ?>
              <li class="nav-item">
                <a href="cart.php" class="nav-link text-white">
                  <i class="nav-icon fas fa-folder"></i>
                  <p>
                    Keranjang
                  </p>
                </a>
              </li>
            <?php } ?>
            <?php if (($_SESSION['level'] == 'admin') || ($_SESSION['level'] == 'pelanggan')) { ?>
              <li class="nav-item">
                <a href="pelacakan.php" class="nav-link text-white">
                  <i class="nav-icon fas fa-location-arrow"></i>
                  <p>
                    Pelacakan
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="daftar_retur.php" class="nav-link text-white">
                  <i class="nav-icon fas fa-undo"></i> <!-- Ganti ikon di sini -->
                  <p>
                    Retur
                  </p>
                </a>
              </li>

            <?php } ?>

            <li class="nav-item">
              <a href="feedback_index.php" class="nav-link text-white">
                <i class="nav-icon fa fa-comment"></i>
                <p>
                  Komentar/Saran
                </p>
              </a>
            </li>


          <?php  ?>

          <?php if ($_SESSION['level'] == 'admin') { ?>
            <li class="nav-item">
              <a href="laporan-index.php" class="nav-link text-white">
                <i class="nav-icon fas fa-flag"></i>
                <p>
                  Laporan
                </p>
              </a>
            </li>
          <?php } ?>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>