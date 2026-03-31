<?php
include './../connections/connections.php';

if (isset($_POST['add_coaching_rates'])) {

  // Set Manila timezone
  date_default_timezone_set('Asia/Manila');

  // Get today's date
  $coaching_date = date('Y-m-d');

  // Retrieve and sanitize POST data
  $coaching_type = isset($_POST['coaching_type']) ? $conn->real_escape_string(trim($_POST['coaching_type'])) : '';
  $coaching_price = isset($_POST['coaching_price']) ? $conn->real_escape_string(trim($_POST['coaching_price'])) : '';
  $client_fullname = isset($_POST['client_fullname']) ? $conn->real_escape_string(trim($_POST['client_fullname'])) : '';

  // INSERT DATA
  $insert_sql = "INSERT INTO coaching_service (coaching_type, coaching_price, client_fullname, coaching_date) 
                 VALUES ('$coaching_type', '$coaching_price', '$client_fullname', '$coaching_date')";

  if (mysqli_query($conn, $insert_sql)) {
    echo json_encode([
      'success' => true,
      'message' => "Coaching Session data has been successfully added to the system."
    ]);
  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Failed to add the Coaching Session data. Please try again later.'
    ]);
  }

  exit();
}
?>