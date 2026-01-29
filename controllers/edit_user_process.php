<?php

include './../connections/connections.php';

if (isset($_POST['edit_users'])) {

  $lakan_user_id = $conn->real_escape_string($_POST['lakan_user_id']);
  $lakan_firstname = $conn->real_escape_string($_POST['lakan_firstname']);
  $lakan_middlename = $conn->real_escape_string($_POST['lakan_middlename']);
  $lakan_lastname = $conn->real_escape_string($_POST['lakan_lastname']);
  $lakan_username = $conn->real_escape_string($_POST['lakan_username']);
  $lakan_email = $conn->real_escape_string($_POST['lakan_email']);

  // Password (optional)
  $lakan_password = $_POST['lakan_password'];

  // Base UPDATE query (no password yet)
  $sql = "UPDATE users SET
            lakan_firstname = '$lakan_firstname',
            lakan_middlename = '$lakan_middlename',
            lakan_lastname = '$lakan_lastname',
            lakan_username = '$lakan_username',
            lakan_email = '$lakan_email'";

  // If password is NOT empty → hash and update it
  if (!empty($lakan_password)) {
    $hashed_password = password_hash($lakan_password, PASSWORD_DEFAULT);
    $sql .= ",
            lakan_password = '$hashed_password',
            lakan_pass_confirm = '$lakan_password'";
  }

  // WHERE clause
  $sql .= " WHERE lakan_user_id = '$lakan_user_id'";

  // Execute
  if (mysqli_query($conn, $sql)) {
    echo json_encode([
      'success' => true,
      'message' => 'User updated successfully!'
    ]);
    exit();
  }

  echo json_encode([
    'success' => false,
    'message' => 'Error updating user: ' . mysqli_error($conn)
  ]);
  exit();
}
