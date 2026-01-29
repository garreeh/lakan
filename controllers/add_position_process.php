<?php
include './../connections/connections.php';

if (isset($_POST['add_position'])) {

  // Retrieve and sanitize POST data
  $position_name = isset($_POST['position_name']) ? $conn->real_escape_string(trim($_POST['position_name'])) : '';
  $position_description = isset($_POST['position_description']) ? $conn->real_escape_string(trim($_POST['position_description'])) : '';

  // FLEXIBLE DUPLICATE CHECK: Only first + last name matter
  $check_sql = "SELECT * FROM position WHERE position_name = '$position_name'";
  $check_result = mysqli_query($conn, $check_sql);

  if ($check_result && mysqli_num_rows($check_result) > 0) {
    echo json_encode([
      'success' => false,
      'message' => "The name $position_name already exists in the system."
    ]);
    exit();
  }

  // INSERT EMPLOYEE
  $insert_sql = "
        INSERT INTO position (position_name, position_description)
        VALUES ('$position_name', '$position_description')
    ";

  if (mysqli_query($conn, $insert_sql)) {
    echo json_encode([
      'success' => true,
      'message' => "$position_name has been successfully added to the system."
    ]);
  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Failed to add the position. Please try again later.'
    ]);
  }

  exit();
}
