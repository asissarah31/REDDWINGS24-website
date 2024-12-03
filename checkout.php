<?php
include 'admin/db_connect.php';

// Check if the cart is empty
$chk = $conn->query("SELECT * FROM cart WHERE user_id = {$_SESSION['login_user_id']}")->num_rows;
if ($chk <= 0) {
    echo "<script>alert('You don\'t have an Item in your cart yet.'); location.replace('./')</script>";
}

// Define delivery fee
$delivery_fee = 30; // Example fixed delivery fee
?>
<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-10 align-self-center mb-4 page-title">
                <h1 class="text-white">Checkout</h1>
                <hr class="divider my-4 bg-dark" />
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="" id="checkout-frm">
                <h4>Confirm Delivery Information</h4>
                <div class="form-group">
                    <label for="" class="control-label">Firstname</label>
                    <input type="text" name="first_name" required class="form-control" value="<?php echo $_SESSION['login_first_name']; ?>">
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Last Name</label>
                    <input type="text" name="last_name" required class="form-control" value="<?php echo $_SESSION['login_last_name']; ?>">
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Contact</label>
                    <input type="text" name="mobile" required class="form-control" value="<?php echo $_SESSION['login_mobile']; ?>">
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Address</label>
                    <textarea cols="30" rows="3" name="address" required class="form-control"><?php echo $_SESSION['login_address']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Email</label>
                    <input type="email" name="email" required class="form-control" value="<?php echo $_SESSION['login_email']; ?>">
                </div>

               <!-- Payment Method Selection -->
<div class="form-group">
    <label for="payment_method" class="control-label">Payment Method</label>
    <select name="payment_method" required class="form-control" id="payment_method">
        <option value="" disabled selected>Select Payment Method</option>
        <option value="COD">Cash on Delivery (COD)</option>
        <option value="GCASH">Online Payment (GCASH)</option>
        <option value="PAYPAL">Online Payment (PAYPAL)</option>
    </select>
</div>

<!-- GCash Information Fields (Initially Hidden) -->
<div id="gcash-info" style="display: none;">
    <h5>GCash Information</h5>
    <div class="form-group">
        <label for="gcash-name" class="control-label">Complete Name</label>
        <input type="text" name="gcash_name" class="form-control" id="gcash-name" placeholder="Enter your full name">
    </div>
    <div class="form-group">
        <label for="gcash-number" class="control-label">GCash Number</label>
        <input type="text" name="gcash_number" class="form-control" id="gcash-number" placeholder="Enter your GCash number">
    </div>
</div>

<!-- PayPal Information Fields (Initially Hidden) -->
<div id="paypal-info" style="display: none;">
    <h5>PayPal Information</h5>
    <div class="form-group">
        <label for="paypal-name" class="control-label">Complete Name</label>
        <input type="text" name="paypal_name" class="form-control" id="paypal-name" placeholder="Enter your full name">
    </div>
    <div class="form-group">
        <label for="paypal-email" class="control-label">PayPal Email</label>
        <input type="email" name="paypal_email" class="form-control" id="paypal-email" placeholder="Enter your PayPal email">
    </div>
</div>

<!-- Display Delivery Fee -->
<div class="form-group">
    <label for="delivery_fee" class="control-label">Delivery Fee</label>
    <input type="text" id="delivery_fee" class="form-control" value="<?php echo $delivery_fee; ?>" readonly>
</div>



<div class="text-center">
    <button class="btn btn-block btn-outline-dark" type="submit">Place Order</button>
</div>


<script>
$(document).ready(function() {
    // Payment method change handler
    $('#payment_method').change(function() {
        var selectedPayment = $(this).val();

        // Hide all payment info fields initially
        $('#gcash-info').hide();
        $('#paypal-info').hide();
        $('#gcash-name').val('');
        $('#gcash-number').val('');
        $('#paypal-name').val('');
        $('#paypal-email').val('');

        // Show the corresponding payment info fields based on the selected payment method
        if (selectedPayment === 'GCASH') {
            $('#gcash-info').show();
        } else if (selectedPayment === 'PAYPAL') {
            $('#paypal-info').show();
        }
    });

    // Form submission
    $('#checkout-frm').submit(function(e) {
        e.preventDefault();
        start_load();

        $.ajax({
            url: "admin/ajax.php?action=save_order", // Ensure this URL processes the form correctly
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp) {
                console.log(resp);  // Debugging the response
                if (resp == 1) {
                    alert_toast("Order successfully placed.");
                    setTimeout(function() {
                        location.replace('index.php?page=home');
                    }, 1500);
                } else if (resp.payment_url) {
                    window.location.href = resp.payment_url;
                } else {
                    alert("There was an error placing your order. Please try again.");
                }
            }
        });
    });
});


</script>
