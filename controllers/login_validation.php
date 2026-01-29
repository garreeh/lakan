<?php
session_start();
include './connections/connections.php';

// Get lakan_user_id from URL
if (!isset($_GET['lakan_user_id']) || empty($_GET['lakan_user_id'])) {
  // No lakan_user_id → redirect to login page
  header("Location: /lakan/index.php");
  exit();
}

$lakan_user_id = intval($_GET['lakan_user_id']); // Sanitize lakan_user_id

// Optional: verify lakan_user_id exists in database
$query = "SELECT lakan_user_id, is_password_reset FROM users WHERE lakan_user_id = $lakan_user_id LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
  // Invalid lakan_user_id → redirect to login
  header("Location: /lakan/views/login.php");
  exit();
}

$user = mysqli_fetch_assoc($result);

// Optional: block access if password already reset
if ($user['is_password_reset'] == 1) {
  header("Location: /lakan/views/dashboard_module.php");
  exit();
}
