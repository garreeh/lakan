<?php

include './../connections/connections.php';

if (isset($_POST['edit_department'])) {

  $department_id = $conn->real_escape_string($_POST['department_id']);
  $department_name = $conn->real_escape_string($_POST['department_name']);
  $department_description = $conn->real_escape_string($_POST['department_description']);

  // Construct SQL query for UPDATE
  $sql = "UPDATE `department` 
          SET 
            department_name = '$department_name',
            department_description = '$department_description'
          WHERE department_id = '$department_id'";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // Department updated successfully
    $response = array('success' => true, 'message' => 'Department updated successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error updating Department
    $response = array('success' => false, 'message' => 'Error updating Department: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
}
