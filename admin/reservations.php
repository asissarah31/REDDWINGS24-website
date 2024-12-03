<?php
include('db_connect.php'); // Include database connection

// Function to send email to customer
function sendEmail($email, $subject, $message) {
    // For simplicity, using PHP's mail function. For production, use libraries like PHPMailer.
    mail($email, $subject, $message);
}

// Fetch reservations with the most recent first
$query = $conn->query("SELECT * FROM reservations ORDER BY date DESC");

// Handle confirmation and denial actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    // Get reservation details
    $result = $conn->query("SELECT * FROM reservations WHERE id='$id'");
    $reservation = $result->fetch_assoc();

    // Get customer email and name for notification
    $customerEmail = $reservation['email'];
    $customerName = $reservation['name'];

    // Update status based on the action
    if ($action == 'confirm') {
        $conn->query("UPDATE reservations SET status='Confirmed' WHERE id='$id'");
        // Send confirmation email to the customer
        $subject = "Your Reservation is Confirmed";
        $message = "Dear $customerName, \n\nYour reservation has been confirmed. We look forward to your visit!";
        sendEmail($customerEmail, $subject, $message);
    } elseif ($action == 'deny') {
        $conn->query("UPDATE reservations SET status='Denied' WHERE id='$id'");
        // Send denial email to the customer
        $subject = "Your Reservation is Denied";
        $message = "Dear $customerName, \n\nUnfortunately, your reservation has been denied due to no tables being available. We apologize for the inconvenience.";
        sendEmail($customerEmail, $subject, $message);
    }

    // Redirect to prevent re-submission
    header("Location: reservations.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 3px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-lg-12">
                <button class="btn btn-primary float-left btn-sm">
                    <i class="fas fa-clipboard-list"></i> Reservation List
                </button> 
                <br><br>
            </div>
        </div>

        <h2>Reservations</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Message</th>
                    <th>Guests</th>
                    <th>Status</th> <!-- Reservation Status -->
                    <th>Action</th> <!-- New Action column -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $query->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['time']); ?></td>
                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                        <td><?php echo htmlspecialchars($row['guests']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td>
                            <?php if ($row['status'] == 'Pending'): ?>
                                <a href="?action=confirm&id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Confirm</a>
                                <a href="?action=deny&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Deny</a>
                            <?php else: ?>
                                <?php echo $row['status']; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
