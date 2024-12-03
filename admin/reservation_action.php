<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if (!in_array($action, ['confirm', 'deny']) || !is_numeric($id)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        exit;
    }

    $newStatus = ($action === 'confirm') ? 'Confirmed: See you There! ' : 'Denied: no tables are available.';
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

