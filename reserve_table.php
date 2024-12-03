<!-- Masthead-->
<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-10 align-self-center mb-4 page-title">
                <h1 class="text-white">Book a Table</h1>
                <hr class="divider my-4 bg-dark" />
            </div>
        </div>
    </div>
</header>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Include database connection
    include('admin/db_connect.php');

    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $guests = $_POST['guests'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = $_POST['message'];

    // Check if there are any reservations at the same time and date
    $check_availability = "SELECT * FROM reservations WHERE date = '$date' AND time = '$time'";
    $result = $conn->query($check_availability);

    if ($result->num_rows > 0) {
        // Reservation exists, so no tables are available
        $reservation_status = " ";
        $status_class = "alert-danger";
    } else {
        // No reservation exists, insert the new reservation
        $sql = "INSERT INTO reservations (name, email, phone, guests, date, time, message, status) 
                VALUES ('$name', '$email', '$phone', '$guests', '$date', '$time', '$message', 'Pending')";

        if ($conn->query($sql) === TRUE) {
            // Success message for a new reservation
            $reservation_status = "Your reservation has been successfully made. We will confirm it shortly.";
            $status_class = "alert-success";
        } else {
            // Error message if the reservation fails
            $reservation_status = "Error: " . $sql . "<br>" . $conn->error;
            $status_class = "alert-danger";
        }
    }

    // Display the reservation status message
    echo "<div class='alert $status_class'>$reservation_status</div>";

    // Close the database connection
    $conn->close();
}
?>

<!-- Reservation Form -->
<div class="container mt-5">
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="guests">Number of Guests</label>
            <input type="number" class="form-control" id="guests" name="guests" required>
        </div>
        <div class="form-group">
            <label for="date">Reservation Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="time">Reservation Time</label>
            <input type="time" class="form-control" id="time" name="time" required>
        </div>
        <div class="form-group">
            <label for="message">Special Requests (optional)</label>
            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Book Now</button>
    </form>
</div>

<?php
// Display reservation status history for a specific customer
// Assuming user is identified by email for simplicity

// Retrieve all reservations for this customer (based on email)
if (isset($_POST['email'])) {
    include('admin/db_connect.php');
    $email = $_POST['email']; // Get email for filtering reservations

    $history_query = "SELECT * FROM reservations WHERE email = '$email' ORDER BY date DESC, time DESC";
    $history_result = $conn->query($history_query);

    if ($history_result->num_rows > 0) {
        echo "<center><h3>Your Reservation History</h3></center>";
        echo "<table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
                <tbody>";
        
        // Display each reservation status change
        while ($row = $history_result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['date']}</td>
                    <td>{$row['time']}</td>
                    <td>{$row['status']}</td>
                    
                </tr>";
        }
        
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-info'>You have no reservation history.</div>";
    }

    $conn->close();
}

?>
