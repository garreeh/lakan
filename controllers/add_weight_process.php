<?php
include './../connections/connections.php';

if (isset($_POST['add_weight'])) {

  $weight_desc = isset($_POST['weight_desc']) ? $conn->real_escape_string(trim($_POST['weight_desc'])) : '';
  $customer_id = isset($_POST['customer_id']) ? $conn->real_escape_string(trim($_POST['customer_id'])) : '';

  // Date today Manila timezone
  date_default_timezone_set('Asia/Manila');
  $date_saved_weight = date('Y-m-d');

  // Insert latest body fat
  $insert_sql = "INSERT INTO weight_history (weight_desc, date_saved_weight, customer_id) 
                 VALUES ('$weight_desc', '$date_saved_weight', '$customer_id')";

  if (mysqli_query($conn, $insert_sql)) {

    // Fetch all body fats for this customer, ascending by date
    $history_sql = "SELECT * FROM weight_history WHERE customer_id = $customer_id ORDER BY date_saved_weight ASC";
    $history_result = mysqli_query($conn, $history_sql);

    $weight_history = [];
    while ($row = mysqli_fetch_assoc($history_result)) {
      $weight_history[] = $row;
    }

    echo json_encode([
      'success' => true,
      'message' => "Latest Weight data has been successfully added to the system.",
      'weight_history' => $weight_history
    ]);
  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Failed to add the Latest Weight. Please try again later.'
    ]);
  }

  exit();
}
?>