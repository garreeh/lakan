<?php
include './../connections/connections.php';

if (isset($_POST['resume_membership'])) {

  // Retrieve and sanitize POST data
  $customer_id = isset($_POST['customer_id']) ? $conn->real_escape_string(trim($_POST['customer_id'])) : '';
  $date_resumed = isset($_POST['date_resumed']) ? $conn->real_escape_string(trim($_POST['date_resumed'])) : '';

  if (empty($customer_id) || empty($date_resumed)) {
    echo json_encode([
      'success' => false,
      'message' => 'Invalid input data.'
    ]);
    exit();
  }

  // Get the old membership dates and pause date
  $query = "SELECT start_date_membership, end_date_membership, date_paused 
              FROM customer 
              WHERE customer_id = '$customer_id' LIMIT 1";
  $result = mysqli_query($conn, $query);

  if (!$result || mysqli_num_rows($result) == 0) {
    echo json_encode([
      'success' => false,
      'message' => 'Customer not found.'
    ]);
    exit();
  }

  $row = mysqli_fetch_assoc($result);
  $old_start = $row['start_date_membership']; // Keep original
  $old_end = $row['end_date_membership'];
  $date_paused = $row['date_paused'];

  // Calculate paused duration in days
  if (!empty($date_paused)) {
    $paused_days = (strtotime($date_resumed) - strtotime($date_paused)) / (60 * 60 * 24);
    if ($paused_days < 0)
      $paused_days = 0; // safety check
  } else {
    $paused_days = 0; // fallback if no pause date
  }

  // New end date = old end date + paused days
  $new_end = date('Y-m-d', strtotime($old_end . " +$paused_days days"));

  // Update customer table
  $update_sql = "UPDATE customer SET 
                    end_date_membership = '$new_end',
                    date_resumed = '$date_resumed',
                    is_paused = 0,
                    last_paused_date = date_paused,
                    date_paused = NULL
                WHERE customer_id = '$customer_id'";

  if (mysqli_query($conn, $update_sql)) {
    echo json_encode([
      'success' => true,
      'message' => "Subscription has been successfully resumed.",
      'original_start_date' => $old_start,
      'new_end_date' => $new_end
    ]);
  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Failed to resume subscription. Please try again later.'
    ]);
  }

  exit();
}
?>