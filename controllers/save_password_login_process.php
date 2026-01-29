<?php
session_start();
include './../connections/connections.php';

// Check required POST fields
if (!isset($_POST['username'], $_POST['emp_password'])) {
  echo json_encode([
    'success' => false,
    'message' => 'Missing required fields.'
  ]);
  exit();
}

// Get emp_id directly from URL
$emp_id = isset($_POST['emp_id']) ? intval($_POST['emp_id']) : 0;

if ($emp_id === 0) {
  echo json_encode([
    'success' => false,
    'message' => 'Oops! We couldn’t find your account. Please use the link provided by HR.'
  ]);
  exit();
}

$username = $conn->real_escape_string(trim($_POST['username']));
$password = $_POST['emp_password'];

// Optional: basic password validation
if (strlen($password) < 6) {
  echo json_encode([
    'success' => false,
    'message' => 'Password must be at least 6 characters.'
  ]);
  exit();
}

// Check for duplicate username
$check_sql = "SELECT emp_id FROM users WHERE emp_username = '$username' AND emp_id != $emp_id LIMIT 1";
$check_result = mysqli_query($conn, $check_sql);

if ($check_result && mysqli_num_rows($check_result) > 0) {
  echo json_encode([
    'success' => false,
    'message' => 'This username is already taken. Please choose another one.'
  ]);
  exit();
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Update employee record
$update_sql = "UPDATE users SET 
              emp_username = '$username',
              emp_password = '$hashedPassword',
              is_password_reset = 1
              WHERE emp_id = $emp_id
              LIMIT 1";

if (mysqli_query($conn, $update_sql)) {
  $query = "SELECT * FROM users WHERE emp_id = $emp_id LIMIT 1";
  $result = mysqli_query($conn, $query);
  $user = mysqli_fetch_assoc($result);

  $_SESSION['emp_id'] = $user['emp_id'];
  $_SESSION['emp_email'] = $user['emp_email'];
  $_SESSION['emp_username'] = $user['emp_username'];
  $_SESSION['emp_firstname'] = $user['emp_firstname'];
  $_SESSION['emp_middlename'] = $user['emp_middlename'];
  $_SESSION['emp_lastname'] = $user['emp_lastname'];
  $_SESSION['user_type_id'] = $user['user_type_id'];
  $_SESSION['employment_status'] = $user['employment_status'];
  $_SESSION['is_password_reset'] = $user['is_password_reset'];

  echo json_encode([
    'success' => true,
    'message' => 'Password saved successfully. Redirecting...',
    'emp_id' => $user['emp_id']
  ]);
  exit();
} else {
  echo json_encode([
    'success' => false,
    'message' => 'Failed to save password. Please try again.'
  ]);
  exit();
}
