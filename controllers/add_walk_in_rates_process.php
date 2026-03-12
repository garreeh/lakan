<?php
include './../connections/connections.php';

if (isset($_POST['add_walkin_rates'])) {

  // Retrieve and sanitize POST data
  $walk_in_type = isset($_POST['walk_in_type']) ? $conn->real_escape_string(trim($_POST['walk_in_type'])) : '';
  $walk_in_price = isset($_POST['walk_in_price']) ? $conn->real_escape_string(trim($_POST['walk_in_price'])) : '';
  $walk_in_name = isset($_POST['walk_in_name']) ? $conn->real_escape_string(trim($_POST['walk_in_name'])) : '';

  // INSERT MEMBERSHIP TYPE
  $insert_sql = "INSERT INTO walk_in (walk_in_type, walk_in_price, walk_in_name) 
                 VALUES ('$walk_in_type', '$walk_in_price', '$walk_in_name')";

  if (mysqli_query($conn, $insert_sql)) {
    echo json_encode([
      'success' => true,
      'message' => "Walk-in data has been successfully added to the system."
    ]);
  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Failed to add the walk-in data. Please try again later.'
    ]);
  }

  exit();
}
