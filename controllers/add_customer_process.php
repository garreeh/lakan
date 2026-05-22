<?php
include './../connections/connections.php';

if (isset($_POST['add_employee'])) {

  // Retrieve and sanitize POST data
  $membership_type_id = isset($_POST['membership_type_id']) ? $conn->real_escape_string(trim($_POST['membership_type_id'])) : '';
  $first_name = isset($_POST['first_name']) ? $conn->real_escape_string(trim($_POST['first_name'])) : '';
  $middle_name = isset($_POST['middle_name']) ? $conn->real_escape_string(trim($_POST['middle_name'])) : '';
  $last_name = isset($_POST['last_name']) ? $conn->real_escape_string(trim($_POST['last_name'])) : '';
  $age = isset($_POST['age']) ? $conn->real_escape_string($_POST['age']) : '';
  $gender = isset($_POST['gender']) ? $conn->real_escape_string($_POST['gender']) : '';
  $start_date_membership = isset($_POST['start_date_membership']) && !empty($_POST['start_date_membership']) ? $conn->real_escape_string($_POST['start_date_membership']) : '0000-00-00';
  $end_date_membership = isset($_POST['end_date_membership']) && !empty($_POST['end_date_membership']) ? $conn->real_escape_string($_POST['end_date_membership']) : '0000-00-00';
  $birth_date = isset($_POST['birth_date']) && !empty($_POST['birth_date']) ? $conn->real_escape_string($_POST['birth_date']) : '0000-00-00';

  // Payment fields
  $payment_type = isset($_POST['payment_type']) ? $conn->real_escape_string($_POST['payment_type']) : '';
  $down_payment_amount = isset($_POST['down_payment_amount']) ? (float) $_POST['down_payment_amount'] : 0;
  $payment_terms = isset($_POST['payment_terms']) ? $conn->real_escape_string($_POST['payment_terms']) : '';

  // -------------------------------
  // EXTRACT MONTHS FROM "3 Months"
  // -------------------------------
  preg_match('/\d+/', $payment_terms, $matches);
  $months_term_remaining = isset($matches[0]) ? (int) $matches[0] : 0;

  // -------------------------------
  // GET MEMBERSHIP PRICE
  // -------------------------------
  $price_sql = "SELECT membershiptype_price 
                FROM membership_type 
                WHERE membership_type_id = '$membership_type_id'";
  $price_result = mysqli_query($conn, $price_sql);
  $price_row = mysqli_fetch_assoc($price_result);

  $membership_price = isset($price_row['membershiptype_price']) ? (float) $price_row['membershiptype_price'] : 0;

  // -------------------------------
  // COMPUTE REMAINING BALANCE
  // -------------------------------
  $remaining_balance = $membership_price - $down_payment_amount;

  if ($remaining_balance < 0) {
    $remaining_balance = 0;
  }

  // -------------------------------
// NORMALIZE DATETIME INPUTS
// -------------------------------
  $start_date_membership = isset($_POST['start_date_membership'])
    ? trim($_POST['start_date_membership'])
    : '';

  $end_date_membership = isset($_POST['end_date_membership'])
    ? trim($_POST['end_date_membership'])
    : '';

  // -------------------------------
// VALIDATION FUNCTION (DATE SAFE)
// -------------------------------
  function isInvalidDate($date)
  {
    return empty($date) ||
      $date === '0000-00-00' ||
      $date === '0000-00-00 00:00:00';
  }

  // -------------------------------
// VALIDATION
// -------------------------------
  if (
    empty($first_name) ||
    empty($last_name) ||
    empty($membership_type_id) ||
    isInvalidDate($start_date_membership) ||
    isInvalidDate($end_date_membership)
  ) {
    echo json_encode([
      'success' => false,
      'message' => 'Start Date and End Date are required.'
    ]);
    exit();
  }
  // -------------------------------
  // DUPLICATE CHECK
  // -------------------------------
  $name_check_sql = "
        SELECT * FROM customer 
        WHERE first_name = '$first_name' 
          AND last_name = '$last_name'
    ";
  $name_check_result = mysqli_query($conn, $name_check_sql);

  if ($name_check_result && mysqli_num_rows($name_check_result) > 0) {
    echo json_encode([
      'success' => false,
      'message' => "A member with the name $first_name $last_name already exists in the system."
    ]);
    exit();
  }

  // -------------------------------
  // INSERT CUSTOMER
  // -------------------------------
  $insert_sql = "INSERT INTO customer (
                  first_name, 
                  middle_name, 
                  last_name, 
                  birth_date, 
                  age, 
                  start_date_membership, 
                  end_date_membership, 
                  gender,
                  payment_type,
                  down_payment_amount,
                  payment_terms,
                  remaining_balance,
                  months_term_remaining,
                  membership_type_id
              )
        VALUES (
                  '$first_name', 
                  '$middle_name', 
                  '$last_name', 
                  '$birth_date', 
                  '$age',
                  '$start_date_membership', 
                  '$end_date_membership', 
                  '$gender',
                  '$payment_type',
                  '$down_payment_amount',
                  '$payment_terms',
                  '$remaining_balance',
                  '$months_term_remaining',
                  '$membership_type_id'
              )";

  if (mysqli_query($conn, $insert_sql)) {
    echo json_encode([
      'success' => true,
      'message' => "Member $first_name $last_name has been successfully added to the system.",
      'remaining_balance' => $remaining_balance,
      'months_term_remaining' => $months_term_remaining
    ]);
  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Failed to add the employee. Please try again later.'
    ]);
  }

  exit();
}