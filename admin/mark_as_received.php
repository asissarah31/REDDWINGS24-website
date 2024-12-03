<?php
include_once('admin/db_connect.php');

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    
    // Update the order status to "Received" (status = 3)
    $stmt = $conn->prepare("UPDATE orders SET status = 3 WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
}
?>
