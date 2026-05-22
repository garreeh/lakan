<?php
include './../connections/connections.php';

if (isset($_POST['add_payment'])) {

  // -------------------------------
  // INPUTS
  // -------------------------------
  $customer_id = isset($_POST['customer_id']) ? (int) $_POST['customer_id'] : 0;
  $payment_amount = isset($_POST['payment_amount']) ? (float) $_POST['payment_amount'] : 0;

  // -------------------------------
  // VALIDATION
  // -------------------------------
  if ($customer_id <= 0 || $payment_amount <= 0) {
    echo json_encode([
      'success' => false,
      'message' => 'This payment cannot be processed because the account is already fully paid.'
    ]);
    exit();
  }

  // -------------------------------
  // GET CUSTOMER DATA
  // -------------------------------
  $get_sql = "SELECT remaining_balance, months_term_remaining 
              FROM customer 
              WHERE customer_id = $customer_id";

  $get_result = mysqli_query($conn, $get_sql);
  $customer = mysqli_fetch_assoc($get_result);

  if (!$customer) {
    echo json_encode([
      'success' => false,
      'message' => 'Customer not found.'
    ]);
    exit();
  }

  $current_balance = (float) $customer['remaining_balance'];
  $current_months = (int) $customer['months_term_remaining'];

  // -------------------------------
  // BLOCK IF FULLY PAID
  // -------------------------------
  if ($current_balance <= 0) {
    echo json_encode([
      'success' => false,
      'message' => 'This customer is already fully paid.'
    ]);
    exit();
  }

  // -------------------------------
  // COMPUTE NEW BALANCE
  // -------------------------------
  $new_balance = $current_balance - $payment_amount;
  if ($new_balance < 0) {
    $new_balance = 0;
  }

  // -------------------------------
  // COMPUTE MONTH DECREMENT
  // (each successful payment reduces 1 month)
  // -------------------------------
  $new_months = $current_months;

  if ($payment_amount > 0 && $current_months > 0) {
    $new_months = $current_months - 1;
  }

  if ($new_months < 0) {
    $new_months = 0;
  }

  // -------------------------------
  // INSERT PAYMENT HISTORY
  // -------------------------------
  $insert_sql = "
    INSERT INTO downpayment_record_customer (customer_id, payment_amount)
    VALUES ($customer_id, $payment_amount)
  ";

  // -------------------------------
  // UPDATE CUSTOMER RECORD
  // -------------------------------
  $update_sql = "
    UPDATE customer 
    SET 
      remaining_balance = $new_balance,
      months_term_remaining = $new_months
    WHERE customer_id = $customer_id
  ";

  // -------------------------------
  // EXECUTE
  // -------------------------------
  if (mysqli_query($conn, $insert_sql) && mysqli_query($conn, $update_sql)) {

    echo json_encode([
      'success' => true,
      'message' => 'Payment recorded successfully.',
      'customer_id' => $customer_id,
      'remaining_balance' => $new_balance,
      'months_term_remaining' => $new_months,
      'monthly_payment' => ($new_months > 0 ? ($new_balance / $new_months) : 0)
    ]);

  } else {

    echo json_encode([
      'success' => false,
      'message' => 'Failed to process payment. Please try again later.'
    ]);
  }

  exit();
}