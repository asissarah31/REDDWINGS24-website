<?php
// Include database connection
include_once('admin/db_connect.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['login_user_id'])) {
    echo "Please log in to rate.";
    exit;
}

// Check if POST data contains the required fields
if (isset($_POST['order_id'], $_POST['ratings']) && is_array($_POST['ratings'])) {
    $user_id = $_SESSION['login_user_id'];
    $order_id = intval($_POST['order_id']);
    $ratings = $_POST['ratings']; // array of food_item_id => rating

    // Prepare an SQL statement for inserting or updating ratings
    $stmt = $conn->prepare("INSERT INTO order_ratings (order_id, food_item_id, rating) VALUES (?, ?, ?)
                            ON DUPLICATE KEY UPDATE rating = VALUES(rating)");

    $stmt->bind_param("iii", $order_id, $food_item_id, $rating);

    // Loop through ratings and save each to the database
    foreach ($ratings as $food_item_id => $rating) {
        $food_item_id = intval($food_item_id);
        $rating = intval($rating);

        // Execute the prepared statement for each food item
        if (!$stmt->execute()) {
            echo "Error saving rating for food item ID $food_item_id.";
            exit;
        }
    }

    // Close the statement
    $stmt->close();

    echo "success";
} else {
    echo "Invalid rating data.";
}

// Close the database connection
$conn->close();
?>

<form id="ratingForm">
    <!-- Assuming you have food items in each order -->
    <div>
        <label for="rating_1">Rate Food Item 1:</label>
        <select class="rating-input" data-food-item-id="1">
            <option value="1">1 - Poor</option>
            <option value="2">2 - Fair</option>
            <option value="3">3 - Good</option>
            <option value="4">4 - Very Good</option>
            <option value="5">5 - Excellent</option>
        </select>
    </div>
    <!-- Repeat for other food items in the order -->

    <button type="button" onclick="submitRatings(<?php echo $order_id; ?>)">Submit Ratings</button>
</form>
