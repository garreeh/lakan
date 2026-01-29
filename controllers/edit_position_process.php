<?php

include './../connections/connections.php';

if (isset($_POST['edit_position'])) {

  $position_id = $conn->real_escape_string($_POST['position_id']);
  $position_name = $conn->real_escape_string($_POST['position_name']);
  $position_description = $conn->real_escape_string($_POST['position_description']);

  // Construct SQL query for UPDATE
  $sql = "UPDATE `position` 
          SET 
            position_name = '$position_name',
            position_description = '$position_description'
          WHERE position_id = '$position_id'";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // Position updated successfully
    $response = array('success' => true, 'message' => 'Position updated successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error updating Position
    $response = array('success' => false, 'message' => 'Error updating Position: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
}
