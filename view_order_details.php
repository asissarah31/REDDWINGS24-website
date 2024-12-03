<?php
// Start the session if it's not already started
// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('admin/db_connect.php');

// Check if the user is logged in and retrieve the user ID
if (!isset($_SESSION['login_user_id'])) {
    echo "<h3>You need to log in to view your orders.</h3>";
    exit();
}

$user_id = $_SESSION['login_user_id'];

// Debugging: Output the user ID
echo "Session User ID: " . $_SESSION['login_user_id'];


// Fetch orders for the logged-in user
$orders = $conn->query("SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY id DESC");

// Display orders or a message if no orders found
if ($orders->num_rows > 0) {
    echo "<h3>Your Orders</h3>";
    while ($row = $orders->fetch_assoc()) {
        // Create a link to view the order details
        echo "<div><a href='view_order_details.php?id=" . htmlspecialchars($row['id']) . "'>order_id: " . htmlspecialchars($row['order_id']) . " - Status: " . htmlspecialchars($row['status']) . "</a></div>";
    }
} else {
    // Debugging: Output the SQL query and the error if it occurs
    echo "<h3>No orders found.</h3>";
    echo "<p>SQL Query: SELECT * FROM orders WHERE user_id = '$user_id'</p>"; // Show the query for debugging
    echo "<p>Error: " . $conn->error . "</p>"; // Show any SQL error
}


// Close the database connection
$conn->close();
?>
