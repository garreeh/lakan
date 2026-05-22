<?php
include './../connections/connections.php';

if (isset($_POST['renew_membership'])) {

  $customer_id = isset($_POST['customer_id']) ? (int) $_POST['customer_id'] : 0;

  $new_start_date = isset($_POST['start_date_membership']) ? $conn->real_escape_string(trim($_POST['start_date_membership'])) : '';
  $new_end_date = isset($_POST['end_date_membership']) ? $conn->real_escape_string(trim($_POST['end_date_membership'])) : '';

  $new_payment_type = isset($_POST['payment_type']) ? $conn->real_escape_string(trim($_POST['payment_type'])) : '';

  $new_down_payment_amount = isset($_POST['down_payment_amount']) ? (float) $_POST['down_payment_amount'] : 0;

  $new_payment_terms = isset($_POST['payment_terms']) ? $conn->real_escape_string(trim($_POST['payment_terms'])) : '';
  $membership_type_id = isset($_POST['membership_type_id']) ? (int) $_POST['membership_type_id'] : 0;

  // =========================
  // VALIDATION
  // =========================
  if (empty($customer_id) || empty($new_start_date) || empty($new_end_date)) {
    echo json_encode([
      'success' => false,
      'message' => 'Please provide Start Date, End Date, and Customer ID.'
    ]);
    exit();
  }

  // =========================
  // GET OLD DATA
  // =========================
  $query = "SELECT start_date_membership, end_date_membership,
                 payment_type, down_payment_amount, payment_terms,
                 membership_type_id
          FROM customer
          WHERE customer_id = $customer_id";

  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);

  if (!$row) {
    echo json_encode([
      'success' => false,
      'message' => 'Customer not found.'
    ]);
    exit();
  }

  // =========================
  // CREATE HISTORY
  // =========================
  $membership_history_id = null;

  if (!empty($row['start_date_membership']) && !empty($row['end_date_membership'])) {

    $insert_history = "INSERT INTO membership_history 
  (customer_id, start_date, end_date, membership_type_id, payment_type, down_payment_amount, payment_terms)
  VALUES (
    $customer_id,
    '{$row['start_date_membership']}',
    '{$row['end_date_membership']}',
    {$row['membership_type_id']},
    '{$row['payment_type']}',
    '{$row['down_payment_amount']}',
    '{$row['payment_terms']}'
  )";

    if (mysqli_query($conn, $insert_history)) {
      $membership_history_id = mysqli_insert_id($conn);
    }
  }

  // =========================
  // UPDATE ONLY EMPTY PAYMENT HISTORY LINKS (IMPORTANT CONDITION)
  // =========================
  if ($membership_history_id) {

    $update_payment_history = "
      UPDATE downpayment_record_customer
      SET membership_history_id = $membership_history_id
      WHERE customer_id = $customer_id
      AND (membership_history_id IS NULL OR membership_history_id = 0)
    ";

    mysqli_query($conn, $update_payment_history);
  }

  // =========================
  // GET MEMBERSHIP PRICE
  // =========================
  $price_sql = "SELECT membershiptype_price 
                FROM membership_type 
                WHERE membership_type_id = $membership_type_id";

  $price_result = mysqli_query($conn, $price_sql);
  $price_row = mysqli_fetch_assoc($price_result);

  $membership_price = isset($price_row['membershiptype_price'])
    ? (float) $price_row['membershiptype_price']
    : 0;

  // =========================
  // COMPUTE BALANCE
  // =========================
  $remaining_balance = $membership_price - $new_down_payment_amount;
  if ($remaining_balance < 0) {
    $remaining_balance = 0;
  }

  // =========================
  // EXTRACT MONTHS
  // =========================
  preg_match('/\d+/', $new_payment_terms, $matches);
  $months_term_remaining = isset($matches[0]) ? (int) $matches[0] : 0;

  // =========================
  // UPDATE CUSTOMER
  // =========================
  $update_sql = "UPDATE customer SET
      start_date_membership = '$new_start_date',
      end_date_membership = '$new_end_date',
      membership_type_id = $membership_type_id,
      payment_type = '$new_payment_type',
      down_payment_amount = $new_down_payment_amount,
      payment_terms = '$new_payment_terms',
      remaining_balance = $remaining_balance,
      months_term_remaining = $months_term_remaining
    WHERE customer_id = $customer_id";

  if (mysqli_query($conn, $update_sql)) {

    echo json_encode([
      'success' => true,
      'message' => 'Membership successfully renewed.',
      'membership_history_id' => $membership_history_id,
      'remaining_balance' => $remaining_balance,
      'months_term_remaining' => $months_term_remaining
    ]);

  } else {

    echo json_encode([
      'success' => false,
      'message' => 'Failed to renew membership.'
    ]);
  }

  exit();
}
?>