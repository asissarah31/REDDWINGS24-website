<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if (!in_array($action, ['confirm', 'deny']) || !is_numeric($id)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        exit;
    }

    $newStatus = ($action === 'confirm') ? 'Confirmed' : 'Denied';
    $updateQuery = $conn->query("UPDATE reservations SET status = '$newStatus' WHERE id = $id");

    if ($updateQuery) {
        echo json_encode(['status' => 'success', 'newStatus' => $newStatus]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book a Table</title>
    <?php include('header.php'); ?>
</head>
<body>
    <!-- Navigation -->
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <h2 class="text-center">Book a Table</h2>

        <!-- Show success message -->
        <?php if (isset($_SESSION['reservation_success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['reservation_success']; unset($_SESSION['reservation_success']); ?>
            </div>
        <?php endif; ?>

        <!-- Show error message -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="reservation.php" method="post">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" name="contact" id="contact" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="date">Reservation Date</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="time">Reservation Time</label>
                <input type="time" name="time" id="time" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="people">Number of People</label>
                <input type="number" name="people" id="people" class="form-control" min="1" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Submit Reservation</button>
        </form>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>

</body>
</html>
