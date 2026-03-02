<?php
include './../connections/connections.php';

if (isset($_POST['pause_membership'])) {

  // Retrieve and sanitize POST data
  $customer_id = isset($_POST['customer_id']) ? $conn->real_escape_string(trim($_POST['customer_id'])) : '';
  $date_paused = isset($_POST['date_paused']) ? $conn->real_escape_string(trim($_POST['date_paused'])) : '';

  // Update customer table with new membership dates
  $update_sql = "UPDATE customer SET date_paused = '$date_paused', is_paused = '1' WHERE customer_id = '$customer_id'";

  if (mysqli_query($conn, $update_sql)) {
    echo json_encode([
      'success' => true,
      'message' => "Subscription has been successfully paused."
    ]);
  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Failed to pause subscription. Please try again later.'
    ]);
  }

  exit();
}
