<?php

include './../connections/connections.php';

if (isset($_POST['edit_membership_type'])) {

  $membership_type_id = $conn->real_escape_string($_POST['membership_type_id']);
  $membership_type_name = $conn->real_escape_string($_POST['membership_type_name']);
  $membershiptype_price = $conn->real_escape_string($_POST['membershiptype_price']);
  $membershiptype_description = $conn->real_escape_string($_POST['membershiptype_description']);

  // Construct SQL query for UPDATE
  $sql = "UPDATE `membership_type` 
          SET 
            membership_type_name = '$membership_type_name',
            membershiptype_price = '$membershiptype_price',
            membershiptype_description = '$membershiptype_description'
          WHERE membership_type_id = '$membership_type_id'";

  // Execute SQL query
  if (mysqli_query($conn, $sql)) {
    // Department updated successfully
    $response = array('success' => true, 'message' => 'Membership Type updated successfully!');
    echo json_encode($response);
    exit();
  } else {
    // Error updating Department
    $response = array('success' => false, 'message' => 'Error updating Membership Type: ' . mysqli_error($conn));
    echo json_encode($response);
    exit();
  }
}
