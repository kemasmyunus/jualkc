<?php
include('koneksi.php');
include('templates/header.php');
include('templates/sidebar.php');

// Check if the user is logged in by checking if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit; // Make sure to stop further execution after redirect
}

$user_id = $_SESSION['user_id'];

// Handle update cart action
if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($koneksi, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id' AND user_id = '$user_id'") or die('Query failed');
    echo "<script>alert('Cart updated successfully!');</script>";
}

// Handle delete item from cart
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($koneksi, "DELETE FROM `cart` WHERE id = '$delete_id' AND user_id = '$user_id'") or die('Query failed');
    echo "<script>alert('Item removed from cart!');window.location='cart.php';</script>";
}

// Handle delete all items from cart
if (isset($_GET['delete_all'])) {
    mysqli_query($koneksi, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');
    echo "<script>alert('All items removed from cart!');window.location='cart.php';</script>";
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="shopping-cart">
        <div class="card">
            <h1 class="title">Produk Di Keranjang</h1>

            <div class="cart-container">
                <?php
                $grand_total = 0;
                // Fetch the cart items for the current user
                $select_cart = mysqli_query($koneksi, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');
                if (mysqli_num_rows($select_cart) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        $sub_total = $fetch_cart['quantity'] * $fetch_cart['price'];
                        $grand_total += $sub_total;
                ?>
                        <div class="cart-item">
                            <div class="item-image">
                                <img src="assets/img/<?php echo $fetch_cart['image']; ?>" alt="<?php echo $fetch_cart['name']; ?>">
                            </div>
                            <div class="item-details">
                                <div class="item-name"><?php echo $fetch_cart['name']; ?></div>
                                <div class="item-price">Rp. <?php echo number_format($fetch_cart['price'], 0, ',', '.'); ?> /-</div>
                                <div class="item-quantity">
                                    <form action="" method="post">
                                        <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                                        <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                                        <input type="submit" name="update_cart" value="Update" class="update-btn">
                                    </form>
                                </div>
                                <div class="item-subtotal">Subtotal: Rp. <?php echo number_format($sub_total, 0, ',', '.'); ?> /-</div>
                            </div>
                            <div class="item-actions">
                                <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm('Delete this item from cart?');"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<p class="empty-cart">Keranjang belanja Anda kosong</p>';
                }
                ?>
            </div>

            <div class="cart-total">
                <p>Total Belanja: Rp. <?php echo number_format($grand_total, 0, ',', '.'); ?> /-</p>
                <div class="cart-buttons">
                    <a href="cart.php?delete_all" class="delete-all-btn <?php echo ($grand_total > 0) ? '' : 'disabled'; ?>" onclick="return confirm('Hapus semua item dari keranjang?');">Hapus Semua</a>
                    <a href="index.php" class="continue-shopping-btn">Lanjut Belanja</a>
                    <a href="checkout.php" class="checkout-btn <?php echo ($grand_total > 0) ? '' : 'disabled'; ?>">Pembayaran</a>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->

<?php
include('templates/footer.php');
?>

<!-- Custom CSS for cart styling -->
<style>
    .content-wrapper {
        background-color: #fff;
        padding: 20px;
    }

    .shopping-cart {
        padding: 20px;
    }

    .title {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .cart-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border: 1px solid #ddd;
        background-color: #fff;
    }

    .item-image img {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }

    .item-details {
        flex: 1;
        margin-left: 20px;
    }

    .item-name {
        font-size: 18px;
        font-weight: bold;
    }

    .item-price {
        font-size: 16px;
        color: #666;
    }

    .item-quantity {
        margin-top: 10px;
    }

    .update-btn {
        padding: 5px 10px;
        background-color: #3498db;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .update-btn:hover {
        background-color: #2980b9;
    }

    .item-subtotal {
        font-size: 16px;
        margin-top: 10px;
    }

    .item-actions {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .delete-btn {
        color: #e74c3c;
        font-size: 18px;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .delete-btn:hover {
        color: #c0392b;
    }

    .empty-cart {
        text-align: center;
        font-size: 18px;
        margin-top: 20px;
    }

    .cart-total {
        margin-top: 20px;
        padding: 10px;
        background-color: #f2f2f2;
        border: 1px solid #ddd;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .cart-total p {
        font-size: 18px;
        font-weight: bold;
    }

    .cart-buttons {
        margin-top: 10px;
        display: flex;
        gap: 10px;
    }

    .delete-all-btn,
    .continue-shopping-btn,
    .checkout-btn {
        padding: 10px 20px;
        color: white;
        text-decoration: none;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .delete-all-btn {
        background-color: #e74c3c;
    }

    .delete-all-btn:hover {
        background-color: #c0392b;
    }

    .continue-shopping-btn {
        background-color: #3498db;
    }

    .continue-shopping-btn:hover {
        background-color: #2980b9;
    }

    .checkout-btn {
        background-color: #27ae60;
    }

    .checkout-btn:hover {
        background-color: #219d54;
    }

    .disabled {
        pointer-events: none;
        opacity: 0.5;
    }
</style>