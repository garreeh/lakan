<?php
session_start();
include './connections/connections.php';

// Get emp_id from URL
if (!isset($_GET['emp_id']) || empty($_GET['emp_id'])) {
  // No emp_id → redirect to login page
  header("Location: /lakan/index.php");
  exit();
}

$emp_id = intval($_GET['emp_id']); // Sanitize emp_id

// Optional: verify emp_id exists in database
$query = "SELECT emp_id, is_password_reset FROM users WHERE emp_id = $emp_id LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
  // Invalid emp_id → redirect to login
  header("Location: /lakan/views/login.php");
  exit();
}

$user = mysqli_fetch_assoc($result);

// Optional: block access if password already reset
if ($user['is_password_reset'] == 1) {
  header("Location: /lakan/views/dashboard_module.php");
  exit();
}
