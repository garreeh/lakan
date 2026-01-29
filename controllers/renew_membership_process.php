<?php
include './../connections/connections.php';

if (isset($_POST['renew_membership'])) {

  // Retrieve and sanitize POST data
  $customer_id = isset($_POST['customer_id']) ? $conn->real_escape_string(trim($_POST['customer_id'])) : '';
  $new_start_date = isset($_POST['start_date_membership']) ? $conn->real_escape_string(trim($_POST['start_date_membership'])) : '';
  $new_end_date = isset($_POST['end_date_membership']) ? $conn->real_escape_string(trim($_POST['end_date_membership'])) : '';
  $membership_type_id = isset($_POST['membership_type_id']) ? $conn->real_escape_string(trim($_POST['membership_type_id'])) : '';

  // Validate fields
  if (empty($customer_id) || empty($new_start_date) || empty($new_end_date)) {
    echo json_encode([
      'success' => false,
      'message' => 'Please provide all required fields.'
    ]);
    exit();
  }

  // Get old membership dates
  $query = "SELECT start_date_membership, end_date_membership FROM customer WHERE customer_id = '$customer_id'";
  $result = mysqli_query($conn, $query);
  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $old_start_date = $row['start_date_membership'];
    $old_end_date = $row['end_date_membership'];
  } else {
    $old_start_date = null;
    $old_end_date = null;
  }

  // Insert old dates into membership_history (only if old dates exist)
  if (!empty($old_start_date) && !empty($old_end_date)) {
    $insert_history = "INSERT INTO membership_history (customer_id, `start_date`, end_date, membership_type_id) 
                           VALUES ('$customer_id', '$old_start_date', '$old_end_date', '$membership_type_id')";
    mysqli_query($conn, $insert_history);
  }

  // Update customer table with new membership dates
  $update_sql = "UPDATE customer 
                   SET start_date_membership = '$new_start_date', 
                       end_date_membership = '$new_end_date',
                       membership_type_id = '$membership_type_id'
                   WHERE customer_id = '$customer_id'";

  if (mysqli_query($conn, $update_sql)) {
    echo json_encode([
      'success' => true,
      'message' => "Membership has been successfully renewed and old dates saved to history."
    ]);
  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Failed to renew membership. Please try again later.'
    ]);
  }

  exit();
}
