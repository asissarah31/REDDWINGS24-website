<?php
// Include the necessary files
include_once('header.php'); 
include_once('admin/db_connect.php');

// Check if order_id is provided
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Prepare the SQL statement to fetch order items and payment mode
    $stmt = $conn->prepare("
        SELECT o.*, p.price, p.name 
        FROM order_list o 
        INNER JOIN product_list p ON o.product_id = p.id 
        WHERE o.order_id = ?
    ");

    // Bind the order ID parameter
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Fetch the order items into an associative array
        $order_list = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $order_list = [];
    }
} else {
    // Redirect if no order ID is provided
    header("Location: orders.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Items</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Ensure to update the path to Bootstrap -->
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Order #<?php echo htmlspecialchars($order_id); ?> Items</h2>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($order_list)): ?>
                    <?php foreach ($order_list as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['qty']); ?></td>
                            <td><?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <img src="assets/img/<?php echo htmlspecialchars($item['product_image']); ?>" class="card-img-top" alt="Product Image" style="width: 100px; height: auto;">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No items found for this order.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="orders.php" class="btn btn-secondary">Back to Orders</a>
    </div>

    <script src="path/to/bootstrap.js"></script> <!-- Ensure to update the path to Bootstrap JS -->
</body>
</html>

<?php
// Close the prepared statement and connection
$stmt->close();
$conn->close();
?>
