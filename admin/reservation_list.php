<?php
include('db_connect.php'); // Include database connection

// Function to send email to customer
function sendEmail($email, $subject, $message) {
    // For simplicity, we're using PHP's mail function here
    // You can use a library like PHPMailer for better functionality
    mail($email, $subject, $message);
}

// Fetch reservations with the most recent first
$query = $conn->query("SELECT * FROM reservations ORDER BY date DESC");
?>

<div class="container-fluid">
    <br>
    <div class="row">
        <div class="col-lg-12">
            <button class="btn btn-primary float-left btn-sm"><i class="fas fa-clipboard-list"></i> Reservation List</button>
            <br><br>
        </div>
    </div>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reservations</title>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // AJAX function to handle confirm/deny action
        function updateStatus(action, id) {
    console.log('Action:', action, 'ID:', id); // Debugging
    $.ajax({
        url: 'reservation_action.php',
        type: 'POST',
        data: { action: action, id: id },
        success: function(response) {
            console.log(response); // Debugging
            const data = JSON.parse(response);
            if (data.status === 'success') {
                $('#status_' + id).text(data.newStatus);
            } else {
                alert('Error: ' + data.message);
            }
        },
        error: function() {
            alert('An error occurred while processing your request.');
        }
    });
}

    </script>
</head>
<body>
    <h2>Reservations</h2>
    <table>
       <thead>
    <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Date</th>
        <th>Time</th>
        <th>Message</th>
        <th>Guests</th>
        <th>Action</th> <!-- Action column -->
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
            <td>
                <?php if ($row['status'] == 'Pending'): ?>
                    <button onclick="updateStatus('confirm', <?php echo $row['id']; ?>)" class="btn btn-success btn-sm">Confirm</button>
                    <button onclick="updateStatus('deny', <?php echo $row['id']; ?>)" class="btn btn-danger btn-sm">Deny</button>
                <?php else: ?>
                    <?php echo $row['status']; ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>

    </table>
</body>
</html>
