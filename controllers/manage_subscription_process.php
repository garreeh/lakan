<?php
include './../connections/connections.php';

if (isset($_POST['manage_subscription'])) {

  $customer_id = isset($_POST['customer_id']) ? (int) $_POST['customer_id'] : 0;

  $new_start_date = isset($_POST['start_date_membership']) ? $conn->real_escape_string(trim($_POST['start_date_membership'])) : '';
  $new_end_date = isset($_POST['end_date_membership']) ? $conn->real_escape_string(trim($_POST['end_date_membership'])) : '';

  $new_payment_type = isset($_POST['payment_type']) ? $conn->real_escape_string(trim($_POST['payment_type'])) : '';

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
  // GET CURRENT CUSTOMER DATA
  // =========================
  $current_sql = "SELECT down_payment_amount FROM customer WHERE customer_id = $customer_id";
  $current_result = mysqli_query($conn, $current_sql);
  $current_row = mysqli_fetch_assoc($current_result);

  $existing_down_payment = isset($current_row['down_payment_amount'])
    ? (float) $current_row['down_payment_amount']
    : 0;

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
  // DEFAULT VALUES
  // =========================
  $new_down_payment_amount = $existing_down_payment;
  $remaining_balance = 0;
  $months_term_remaining = 0;

  // =========================
  // PAYMENT TYPE LOGIC
  // =========================
  if ($new_payment_type === 'Downpayment') {

    $new_down_payment_amount = isset($_POST['down_payment_amount']) && $_POST['down_payment_amount'] !== ''
      ? (float) $_POST['down_payment_amount']
      : $existing_down_payment;

    $remaining_balance = $membership_price - $new_down_payment_amount;
    if ($remaining_balance < 0) {
      $remaining_balance = 0;
    }

    preg_match('/\d+/', $new_payment_terms, $matches);
    $months_term_remaining = isset($matches[0]) ? (int) $matches[0] : 0;

  } else {

    // FULL PAYMENT → keep existing or reset safely
    $new_down_payment_amount = 0;
    $remaining_balance = 0;
    $months_term_remaining = 0;
  }

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
      'message' => 'Subscription successfully updated.',
      'remaining_balance' => $remaining_balance,
      'months_term_remaining' => $months_term_remaining,
      'down_payment_amount' => $new_down_payment_amount
    ]);

  } else {

    echo json_encode([
      'success' => false,
      'message' => 'Failed to update subscription.'
    ]);
  }

  exit();
}
?>