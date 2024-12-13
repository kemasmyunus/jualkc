<?php
include('koneksi.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the ID

    // Query to fetch order details
    $query = "SELECT bayar.*, cart.name, cart.price, cart.quantity, pelanggan.nama AS customer_name
              FROM bayar
              JOIN cart ON bayar.id_cart = cart.id
              JOIN pelanggan ON bayar.user_id = pelanggan.id
              WHERE bayar.id = ?";
    
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Prepare data for the receipt
        $customerName = htmlspecialchars($row['customer_name']);
        $address = htmlspecialchars($row['alamat']);
        $phone = htmlspecialchars($row['telepon']);
        $items = [];
        $totalPrice = 0;

        // Assume you want to display items in the receipt
        $items[] = [
            'name' => htmlspecialchars($row['name']),
            'price' => $row['price'],
            'quantity' => $row['quantity'],
            'total' => $row['price'] * $row['quantity'],
        ];
        $totalPrice += $items[0]['total'];

        // Determine the logo to display
        $logo = '';
        if (strpos($row['nama_bank'], 'bri') !== false) {
            $logo = 'assets/img/bri.png';
        } elseif (strpos($row['nama_bank'], 'bca') !== false) {
            $logo = 'assets/img/bca.png';
        } elseif (strpos($row['nama_ewallet'], 'dana') !== false) {
            $logo = 'assets/img/dana.png';
        } elseif (strpos($row['nama_ewallet'], 'shopeepay') !== false) {
            $logo = 'assets/img/shopeepay.png';
        }

        // Debugging: Check logo value
        // var_dump($logo); // Uncomment this line to debug the logo path

        // Generate receipt HTML
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Print Receipt</title>
            <style>
                body { font-family: Arial, sans-serif; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 8px; }
                th { background-color: #f2f2f2; }
                h1 { text-align: center; }
                .logo { display: block; margin: 0 auto; width: 100px; } /* Adjust the width as needed */
            </style>
        </head>
        <body>
            <h1>Receipt</h1>
            <?php if ($logo && file_exists($logo)): ?>
                <img src="<?= $logo ?>" alt="Logo" class="logo">
            <?php else: ?>
                <p>No logo available</p> <!-- Display message if no logo -->
            <?php endif; ?>
            <p><strong>Name:</strong> <?= $customerName ?></p>
            <p><strong>Address:</strong> <?= $address ?></p>
            <p><strong>Phone:</strong> <?= $phone ?></p>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= $item['name'] ?></td>
                            <td>Rp. <?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>Rp. <?= number_format($item['total'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3"><strong>Grand Total</strong></td>
                        <td><strong>Rp. <?= number_format($totalPrice, 0, ',', '.') ?></strong></td>
                    </tr>
                </tbody>
            </table>
            <script>
                window.print();
            </script>
        </body>
        </html>
        <?php
        exit;
    } else {
        echo "No record found.";
    }
} else {
    echo "Invalid request.";
}
?>
