<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Orders</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    include 'db_connect.php';
                    
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    
                    $qry = $conn->query("SELECT id, user_id, name, address, email, mobile, status FROM orders");

                    if (!$qry) {
                        die("Query error: " . $conn->error);
                    }

                    if ($qry->num_rows > 0):
                        while ($row = $qry->fetch_assoc()): 
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                        <td>
                            <?php 
                                if ($row['status'] == 0) echo 'Pending Confirmation';
                                elseif ($row['status'] == 1) echo 'Confirmed';
                                elseif ($row['status'] == 2) echo 'Out for Delivery';
                                elseif ($row['status'] == 3) echo 'Delivered';
                                else echo 'Verification';
                            ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 1): ?>
                                <button class="btn btn-primary btn-sm" onclick="markOutForDelivery(<?php echo $row['id']; ?>)">
                                    Mark as Out for Delivery
                                </button>
                            <?php elseif ($row['status'] == 2): ?>
                                <button class="btn btn-success btn-sm" onclick="markAsReceived(<?php echo $row['id']; ?>)">
                                    Pending Delivery Confirmation
                                </button>
                            <?php elseif ($row['status'] == 3): ?>
                                <span class="text-success">Order Delivered Successfully</span>
                            <?php elseif ($row['status'] == 0): ?>
                                <span class="text-warning">Pending Confirmation</span>
                            <?php endif; ?>
                        </td>
					<td>
                            <button class="btn btn-sm btn-primary view_order" data-id="<?php echo $row['id']; ?>">View Order</button>
                        </td>                    </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan='7' class="text-center">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX Status Update -->
<script src="path/to/jquery.js"></script>
<script>
    function markOutForDelivery(orderId) {
        $.ajax({
            url: 'mark_out_for_delivery.php',
            method: 'POST',
            data: { order_id: orderId },
            success: function(response) {
                if (response.trim() === 'success') {
                    alert('Order marked as Out for Delivery.');
                    location.reload();
                } else {
                    alert('Failed to update order status.');
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    }

   
    $('.view_order').click(function() {
        uni_modal('Order', 'view_order.php?id=' + $(this).attr('data-id'));
    });
</script>
