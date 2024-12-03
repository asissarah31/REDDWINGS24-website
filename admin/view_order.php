<div class="container-fluid">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Qty</th>
                <th>Order</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            $fixed_delivery_fee = 30; // Set fixed delivery fee
            include 'db_connect.php';

            // Fetch order items and payment mode
            $order_id = $_GET['id'];
            $qry = $conn->query("SELECT o.*, p.price, p.name 
                FROM order_list o 
                INNER JOIN product_list p ON o.product_id = p.id 
                WHERE o.order_id = $order_id");

            // Check if the query returns any results
            if ($qry->num_rows > 0) {
                while ($row = $qry->fetch_assoc()):
                    // Check if 'price' key exists to avoid null access
                    $price = isset($row['price']) ? $row['price'] : 0;
                    $total += $row['qty'] * $price; // Ensure price is present in the row
            ?>
            <tr>
                <td><?php echo $row['qty'] ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo number_format($row['qty'] * $price, 2); ?></td>
            </tr>
            <?php 
                endwhile; 
            } else {
                // If no orders are found, display a message
                echo "<tr><td colspan='3' class='text-center'>No orders found for this ID.</td></tr>";
            }

            // Fetch the payment mode separately
            $payment_method_query = $conn->query("SELECT payment_method FROM order_list WHERE order_id = $order_id LIMIT 1");
            $payment_method = $payment_method_query->fetch_assoc();
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-right">Subtotal</th>
                <th><?php echo number_format($total, 2); ?></th>
            </tr>
            <tr>
                <th colspan="2" class="text-right">Delivery Fee</th>
                <th><?php echo number_format($fixed_delivery_fee, 2); ?></th>
            </tr>
            <tr>
                <th colspan="2" class="text-right">TOTAL</th>
                <th><?php echo number_format($total + $fixed_delivery_fee, 2); ?></th>
            </tr>
        </tfoot>
    </table>
    
    <!-- Display Payment Mode -->
    <div class="text-center">
        <strong>Payment Mode:</strong> 
        <?php 
            // Check if payment mode is set and not empty
            if (isset($payment_method['payment_method']) && !empty($payment_method['payment_method'])) {
                echo htmlspecialchars($payment_method['payment_method']);
            } else {
                echo 'Not specified';
            }
        ?>
    </div>
    
    <!-- Status Update Buttons -->
    <div class="text-center">
        <button class="btn btn-primary" id="confirm" type="button" onclick="confirm_order()">Confirm</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>

</div>

<style>
    #uni_modal .modal-footer {
        display: none;
    }
</style>
<script>
    function confirm_order() {
        start_load();
        $.ajax({
            url: 'ajax.php?action=confirm_order',
            method: 'POST',
            data: { id: '<?php echo $_GET['id'] ?>' },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Order confirmed.");
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>

	<script src="path/to/bootstrap.js"></script> <!-- Ensure to update the path to Bootstrap JS -->
    <script src="path/to/jquery.js"></script> <!-- Add jQuery if not already included -->
    <script>
    function markOutForDelivery(orderId) {
        if (confirm("Are you sure you want to mark this order as Out for Delivery?")) {
            $.ajax({
                url: 'mark_out_for_delivery.php',  // Make sure this points to the correct script
                method: 'POST',
                data: { order_id: orderId },
                success: function(response) {
                    if (response == 'success') {
                        alert('Order marked as Out for Delivery.');
                        location.reload(); // Reload to update the status
                    } else {
                        alert('Failed to update the order status.');
                    }
                }
            });
        }
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
    </script>

<script>
   function update_order_status(status) {
    $.ajax({
        url: 'ajax.php?action=update_order_status',
        method: 'POST',
        data: { id: '<?php echo $_GET['id'] ?>', status: status },
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Order status updated to " + status + ".");
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                alert_toast("Failed to update order status.", "error");
            }
        }
    });
}

</script>
