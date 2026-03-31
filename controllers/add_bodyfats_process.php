<?php
include './../connections/connections.php';

if (isset($_POST['add_latest_body_fats'])) {

  $bodyfats_desc = isset($_POST['bodyfats_desc']) ? $conn->real_escape_string(trim($_POST['bodyfats_desc'])) : '';
  $customer_id = isset($_POST['customer_id']) ? $conn->real_escape_string(trim($_POST['customer_id'])) : '';

  // Date today Manila timezone
  date_default_timezone_set('Asia/Manila');
  $date_saved_bodyfats = date('Y-m-d');

  // Insert latest body fat
  $insert_sql = "INSERT INTO body_fats_history (bodyfats_desc, date_saved_bodyfats, customer_id) 
                 VALUES ('$bodyfats_desc', '$date_saved_bodyfats', '$customer_id')";

  if (mysqli_query($conn, $insert_sql)) {

    // Fetch all body fats for this customer, ascending by date
    $history_sql = "SELECT * FROM body_fats_history WHERE customer_id = $customer_id ORDER BY date_saved_bodyfats ASC";
    $history_result = mysqli_query($conn, $history_sql);

    $body_fats_history = [];
    while ($row = mysqli_fetch_assoc($history_result)) {
      $body_fats_history[] = $row;
    }

    echo json_encode([
      'success' => true,
      'message' => "Latest Body Fat data has been successfully added to the system.",
      'body_fats_history' => $body_fats_history
    ]);
  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Failed to add the Latest Body Fat. Please try again later.'
    ]);
  }

  exit();
}
?>