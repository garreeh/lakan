<?php
include './../connections/connections.php';

if (isset($_POST['add_membership_type'])) {

  // Retrieve and sanitize POST data
  $membership_type_name = isset($_POST['membership_type_name']) ? $conn->real_escape_string(trim($_POST['membership_type_name'])) : '';
  $membershiptype_price = isset($_POST['membershiptype_price']) ? $conn->real_escape_string(trim($_POST['membershiptype_price'])) : '';
  $membershiptype_description = isset($_POST['membershiptype_description']) ? $conn->real_escape_string(trim($_POST['membershiptype_description'])) : '';

  // FLEXIBLE DUPLICATE CHECK: Only first + last name matter
  $check_sql = "SELECT * FROM membership_type WHERE membership_type_name = '$membership_type_name'";
  $check_result = mysqli_query($conn, $check_sql);

  if ($check_result && mysqli_num_rows($check_result) > 0) {
    echo json_encode([
      'success' => false,
      'message' => "The name $membership_type_name already exists in the system."
    ]);
    exit();
  }

  // INSERT MEMBERSHIP TYPE
  $insert_sql = "INSERT INTO membership_type (membership_type_name, membershiptype_price, membershiptype_description) 
                 VALUES ('$membership_type_name', '$membershiptype_price', '$membershiptype_description')";

  if (mysqli_query($conn, $insert_sql)) {
    echo json_encode([
      'success' => true,
      'message' => "$membership_type_name has been successfully added to the system."
    ]);
  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Failed to add the Department. Please try again later.'
    ]);
  }

  exit();
}
