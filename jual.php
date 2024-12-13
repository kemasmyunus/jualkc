<?php
include('koneksi.php');
include('templates/header.php');
include('templates/sidebar.php');

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to add items to the cart.');window.location='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle add to cart action
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];
    $product_ukuran = $_POST['product_ukuran'];
    $product_warna = $_POST['product_warna'];

    $check_cart_numbers = mysqli_query($koneksi, "SELECT * FROM cart WHERE name = '$product_name' AND user_id = '$user_id'") or die('Query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        echo "<script>alert('Product already added to cart!');window.location='jual.php';</script>";
    } else {
        mysqli_query($koneksi, "INSERT INTO cart(user_id, name, price, quantity, image, ukuran, warna) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image', '$product_ukuran', '$product_warna')") or die('Query failed');
        echo "<script>alert('Product added to cart!');window.location='jual.php';</script>";
    }
}

// Handle search form submission
$search = "";
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_POST['search']);
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pembelian Kacamata</h1>
                </div>
            </div>
            <!-- Search Form -->
            <div class="row mb-4">
                <div class="col-sm-12">
                    <form action="" method="post" class="form-inline">
                        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search" value="<?= htmlspecialchars($search); ?>">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <?php
                    // Fetch products from the database, with search functionality
                    $query = "SELECT * FROM daftar_barang";
                    if (!empty($search)) {
                        $query .= " WHERE nama LIKE '%$search%'";
                    }
                    $datas = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

                    // Check if products exist
                    if (mysqli_num_rows($datas) > 0) {
                        // Loop through each product and display it
                        while ($row = mysqli_fetch_assoc($datas)) {
                    ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card h-100 shadow-sm product-card">
                                    <img src="assets/img/<?= htmlspecialchars($row['foto']); ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama']); ?>" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong><?= htmlspecialchars($row['nama']); ?></strong></h5>
                                        <br>
                                        <p>DESKRIPSI BARANG:</p>
                                        <p><?= htmlspecialchars($row['deskripsi']); ?></p>
                                        <p class="card-text">
                                            <strong>Stok:</strong> <?= htmlspecialchars($row['satuan']); ?><br>
                                            <strong class="price">Rp <?= number_format($row['harga_jual'], 0, ',', '.'); ?></strong>
                                        </p>
                                        <div class="form-group">
                                            <label for="qty-<?= $row['id']; ?>"><i class="fas fa-sort-numeric-up"></i> Jumlah:</label>
                                            <input type="number" id="qty-<?= $row['id']; ?>" min="1" name="product_quantity" value="1" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="warna-<?= $row['id']; ?>"><i class="fas fa-palette"></i> Warna:</label>
                                            <select id="warna-<?= $row['id']; ?>" name="product_warna" class="form-control">
                                                <option value="Merah">Merah</option>
                                                <option value="Biru">Biru</option>
                                                <option value="Hitam">Hitam</option>
                                                <option value="Kuning">Kuning</option>
                                                <option value="Polos">Polos</option>
                                                <!-- Add more options dynamically based on your database -->
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label><i class="fas"></i> Ukuran:</label><br>
                                            <?php
                                            $sizes = ['0.0' => '0.0 (FRAME SAJA)', '1.0' => '1.0', '2.0' => '2.0', '3.0' => '3.0', '4.0' => '4.0'];
                                            foreach ($sizes as $value => $label) {
                                                echo '<div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="ukuran-' . $row['id'] . '-' . $value . '" name="product_ukuran" value="' . $value . '" class="custom-control-input">
                                                        <label class="custom-control-label" for="ukuran-' . $row['id'] . '-' . $value . '">' . $label . '</label>
                                                      </div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <form action="" method="post">
                                            <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                                            <input type="hidden" name="product_name" value="<?= htmlspecialchars($row['nama']); ?>">
                                            <input type="hidden" name="product_price" value="<?= htmlspecialchars($row['harga_jual']); ?>">
                                            <input type="hidden" name="product_image" value="<?= htmlspecialchars($row['foto']); ?>">
                                            <input type="hidden" name="product_quantity" id="qty-<?= $row['id']; ?>-input" value="1">
                                            <input type="hidden" name="product_warna" id="warna-<?= $row['id']; ?>-input" value="Merah">
                                            <input type="hidden" name="product_ukuran" id="ukuran-<?= $row['id']; ?>-input" value="0.0">
                                            <a href="https://wa.me/6281234567890" class="btn btn-sm btn-success float-left">
                                                <i class="fas fa-comment"></i>
                                            </a>
                                            <button type="submit" name="add_to_cart" class="btn btn-buy btn-sm buy-btn" onclick="updateFields(<?= $row['id']; ?>)">Beli</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p>No products found.</p>";
                    }
                    ?>
                </div>
            </div>

        </div>
    </section>
    
    <section class="content">
        <div class="card">            
            <div class="card">
                <div class="card-body">
                    <?php
                    // Fetch recommended products from the database
                    $datas = mysqli_query($koneksi, "SELECT daftar_barang.*, rekomendasi.quantity as rekomendasi_quantity, rekomendasi.color as rekomendasi_color, rekomendasi.size as rekomendasi_size 
                                                    FROM rekomendasi 
                                                    INNER JOIN daftar_barang ON rekomendasi.product_id = daftar_barang.id 
                                                    WHERE rekomendasi.pelanggan_id = '$user_id'") or die(mysqli_error($koneksi));
        
                    // Check if there are any recommended products
                    if (mysqli_num_rows($datas) > 0) {
                    ?>
                        <h2 class="text-center">Barang Rekomendasi</h2>
                        <div class="row">
                            <?php
                            // Loop through each recommended product and display it
                            while ($row = mysqli_fetch_assoc($datas)) {
                            ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="card h-100 shadow-sm product-card">
                                        <img src="assets/img/<?= htmlspecialchars($row['foto']); ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama']); ?>" style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title"><strong><?= htmlspecialchars($row['nama']); ?></strong></h5>
                                            <br>
                                            <p>DESKRIPSI BARANG:</p>
                                            <p><?= htmlspecialchars($row['deskripsi']); ?></p>
                                            <p class="card-text">
                                                <strong>Stok:</strong> <?= htmlspecialchars($row['satuan']); ?><br>
                                                <strong class="price">Rp <?= number_format($row['harga_jual'], 0, ',', '.'); ?></strong>
                                            </p>
                                            <div class="form-group">
                                                <label for="qty-recommend-<?= $row['id']; ?>"><i class="fas fa-sort-numeric-up"></i> Jumlah:</label>
                                                <input type="number" id="qty-recommend-<?= $row['id']; ?>" min="1" name="product_quantity" value="<?= $row['rekomendasi_quantity']; ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="warna-recommend-<?= $row['id']; ?>"><i class="fas fa-palette"></i> Warna:</label>
                                                <select id="warna-recommend-<?= $row['id']; ?>" name="product_warna" class="form-control">
                                                    <option value="Merah" <?= ($row['rekomendasi_color'] == 'Merah') ? 'selected' : ''; ?>>Merah</option>
                                                    <option value="Biru" <?= ($row['rekomendasi_color'] == 'Biru') ? 'selected' : ''; ?>>Biru</option>
                                                    <option value="Hitam" <?= ($row['rekomendasi_color'] == 'Hitam') ? 'selected' : ''; ?>>Hitam</option>
                                                    <option value="Kuning" <?= ($row['rekomendasi_color'] == 'Kuning') ? 'selected' : ''; ?>>Kuning</option>
                                                    <option value="Polos" <?= ($row['rekomendasi_color'] == 'Polos') ? 'selected' : ''; ?>>Polos</option>
                                                    <!-- Add more options dynamically based on your database -->
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label><i class="fas"></i> Ukuran:</label><br>
                                                <?php
                                                foreach ($sizes as $value => $label) {
                                                    echo '<div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="ukuran-recommend-' . $row['id'] . '-' . $value . '" name="product_ukuran" value="' . $value . '" class="custom-control-input" ' . (($row['rekomendasi_size'] == $value) ? 'checked' : '') . '>
                                                            <label class="custom-control-label" for="ukuran-recommend-' . $row['id'] . '-' . $value . '">' . $label . '</label>
                                                          </div>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center">
                                            <form action="" method="post">
                                                <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                                                <input type="hidden" name="product_name" value="<?= htmlspecialchars($row['nama']); ?>">
                                                <input type="hidden" name="product_price" value="<?= htmlspecialchars($row['harga_jual']); ?>">
                                                <input type="hidden" name="product_image" value="<?= htmlspecialchars($row['foto']); ?>">
                                                <input type="hidden" name="product_quantity" id="qty-recommend-<?= $row['id']; ?>-input" value="<?= $row['rekomendasi_quantity']; ?>">
                                                <input type="hidden" name="product_warna" id="warna-recommend-<?= $row['id']; ?>-input" value="<?= $row['rekomendasi_color']; ?>">
                                                <input type="hidden" name="product_ukuran" id="ukuran-recommend-<?= $row['id']; ?>-input" value="<?= $row['rekomendasi_size']; ?>">
                                                <a href="https://wa.me/6281234567890" class="btn btn-sm btn-success float-left">
                                                    <i class="fas fa-comment"></i>
                                                </a>
                                                <button type="submit" name="add_to_cart" class="btn btn-buy btn-sm buy-btn" onclick="updateFields(<?= $row['id']; ?>)">Beli</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    } else {
                        echo "<p>No recommended products found.</p>";
                    }
                    ?>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
function updateFields(productId) {
    document.getElementById('qty-' + productId + '-input').value = document.getElementById('qty-' + productId).value;
    document.getElementById('warna-' + productId + '-input').value = document.getElementById('warna-' + productId).value;
    document.getElementById('ukuran-' + productId + '-input').value = document.querySelector('input[name="product_ukuran"]:checked').value;
}
</script>

<?php include('templates/footer.php'); ?>
