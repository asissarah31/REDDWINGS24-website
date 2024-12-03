<?php
include 'db_connect.php';

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $update_query = "UPDATE orders SET status = 2 WHERE id = '$order_id'";

    if ($conn->query($update_query) === TRUE) {
        echo 'success';
    } else {
        echo 'Error updating record: ' . $conn->error;
    }
} else {
    echo 'Invalid request';
}
?>
