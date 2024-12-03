<?php
// Include necessary files
include_once('admin/db_connect.php');

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    
    // Prepare and update the order status to "Out for Delivery" (status = 2)
    $stmt = $conn->prepare("UPDATE orders SET status = 2 WHERE id = ?");
    $stmt->bind_param('i', $order_id);
    
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
}
?>
