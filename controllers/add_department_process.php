<?php
include './../connections/connections.php';

if (isset($_POST['add_department'])) {

  // Retrieve and sanitize POST data
  $department_name = isset($_POST['department_name']) ? $conn->real_escape_string(trim($_POST['department_name'])) : '';
  $department_description = isset($_POST['department_description']) ? $conn->real_escape_string(trim($_POST['department_description'])) : '';

  // FLEXIBLE DUPLICATE CHECK: Only first + last name matter
  $check_sql = "SELECT * FROM department WHERE department_name = '$department_name'";
  $check_result = mysqli_query($conn, $check_sql);

  if ($check_result && mysqli_num_rows($check_result) > 0) {
    echo json_encode([
      'success' => false,
      'message' => "The name $department_name already exists in the system."
    ]);
    exit();
  }

  // INSERT EMPLOYEE
  $insert_sql = "
        INSERT INTO department (department_name, department_description)
        VALUES ('$department_name', '$department_description')
    ";

  if (mysqli_query($conn, $insert_sql)) {
    echo json_encode([
      'success' => true,
      'message' => "$department_name has been successfully added to the system."
    ]);
  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Failed to add the Department. Please try again later.'
    ]);
  }

  exit();
}
