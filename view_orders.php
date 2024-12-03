<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once('header.php'); 
include_once('admin/db_connect.php');

$user_id = $_SESSION['login_user_id'];

if (!$user_id) {
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT o.id AS order_id, 
           o.order_date, 
           o.status, 
           o.total, 
           ol.payment_method 
    FROM orders o 
    LEFT JOIN order_list ol ON o.id = ol.order_id 
    LEFT JOIN user_info u ON o.user_id = u.user_id 
    WHERE o.user_id = ? AND (o.status = 1 OR o.status = 0 OR o.status = 2 OR o.status = 3)  -- Added 'Delivered' (3) for rating
    ORDER BY o.order_date DESC
");

$stmt->bind_param('i', $user_id);
$stmt->execute();
$query = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
</head>
<body>
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-10 align-self-center mb-4 page-title">
                    <h1 class="text-white">Your Orders</h1>
                    <hr class="divider my-4 bg-dark" />
                </div>
            </div>
        </div>
    </header>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Order History</h2>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($query->num_rows > 0): ?>
                    <?php while ($row = $query->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($row['order_date'])); ?></td>
                            <td>
                                <?php 
                                    if ($row['status'] == 0) echo 'Pending Confirmation';
                                    elseif ($row['status'] == 1) echo 'Confirmed';
                                    elseif ($row['status'] == 2) echo 'Out for Delivery';
                                    elseif ($row['status'] == 3) echo 'Delivered';
                                    elseif ($row['status'] == 4) echo 'Completed';
                                ?>
                            </td>
                            <td>
                                <?php if ($row['status'] == 1): ?>
                                    <button class="btn btn-primary btn-sm" onclick="markOutForDelivery(<?php echo $row['order_id']; ?>)">
                                         Out for Delivery
                                    </button>
                                <?php elseif ($row['status'] == 2): ?>
                                    <button class="btn btn-success btn-sm" onclick="markAsReceived(<?php echo $row['order_id']; ?>)">
                                      Mark as Order Received
                                    </button>
                                <?php elseif ($row['status'] == 3): ?>
                                    <button class="btn btn-warning btn-sm" onclick="markAsCompleted(<?php echo $row['order_id']; ?>)">
                                       Completed
                                    </button>
                                <?php elseif ($row['status'] == 4): ?>
                                    <button class="btn btn-info btn-sm rate_order" data-id="<?php echo $row['order_id']; ?>">Rate Order</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
	


    <!-- Rating Modal -->
    <div class="modal fade" id="rateOrderModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rate Your Order</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="rateForm">
                        <div class="form-group">
                            <label for="rating">Rating:</label>
                            <select name="rating" id="rating" class="form-control">
                                <option value="5">5 - Excellent</option>
                                <option value="4">4 - Good</option>
                                <option value="3">3 - Average</option>
                                <option value="2">2 - Poor</option>
                                <option value="1">1 - Terrible</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="review">Review:</label>
                            <textarea name="review" id="review" class="form-control" rows="3"></textarea>
                        </div>
                        <input type="hidden" id="order_id" name="order_id">
                        <button type="submit" class="btn btn-primary">Submit Rating</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="path/to/bootstrap.js"></script>
    <script src="path/to/jquery.js"></script>
    <script>
	
	function submitRatings(orderId) {
    const ratings = {};
    
    // Gather ratings from input fields (assuming each rating input has an ID like "rating_{food_item_id}")
    document.querySelectorAll('.rating-input').forEach(input => {
        const foodItemId = input.getAttribute('data-food-item-id');
        const ratingValue = input.value;
        ratings[foodItemId] = ratingValue;
    });

    // Send ratings to the server via AJAX
    $.ajax({
        url: 'submit_rating.php',
        method: 'POST',
        data: { order_id: orderId, ratings: ratings },
        success: function(response) {
            if (response === 'success') {
                alert('Ratings submitted successfully.');
            } else {
                alert('Failed to submit ratings: ' + response);
            }
        }
    });
}

	
      function markAsReceived(orderId) {
        if (confirm("Are you sure you want to mark this order as received?")) {
            $.ajax({
                url: 'mark_as_received.php', // Ensure this is the correct script for marking as received
                method: 'POST',
                data: { order_id: orderId },
                success: function(response) {
                    if (response == 'success') {
                        alert('Order marked as received.');
                        location.reload(); // Reload to update the status
                    } else {
                        alert('Failed to update the order status.');
                    }
                }
            });
        }
    }

        $('.rate_order').click(function() {
            const orderId = $(this).data('id');
            $('#order_id').val(orderId);
            $('#rateOrderModal').modal('show');
        });

        $('#rateForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'submit_rating.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response === 'success') {
                        alert('Thank you for your rating!');
                        $('#rateOrderModal').modal('hide');
                    } else {
                        alert('Failed to submit your rating.');
                    }
                }
            });
        });
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
