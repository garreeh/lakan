<?php

include './../connections/connections.php';

if (isset($_POST['add_users'])) {

  $lakan_firstname = $conn->real_escape_string($_POST['lakan_firstname']);
  $lakan_middlename = $conn->real_escape_string($_POST['lakan_middlename']);
  $lakan_lastname = $conn->real_escape_string($_POST['lakan_lastname']);
  $lakan_username = $conn->real_escape_string($_POST['lakan_username']);
  $lakan_email  = $conn->real_escape_string($_POST['lakan_email']);

  // RAW password (not saved directly)
  $lakan_password = $_POST['lakan_password'];

  // HASHED password (this is what goes to DB)
  $hashed_password = password_hash($lakan_password, PASSWORD_DEFAULT);

  // CHECK DUPLICATE USERNAME OR EMAIL
  $check_sql = "SELECT * FROM users 
                WHERE lakan_username = '$lakan_username' 
                OR lakan_email = '$lakan_email'";
  $check_result = mysqli_query($conn, $check_sql);

  if (mysqli_num_rows($check_result) > 0) {
    echo json_encode([
      'success' => false,
      'message' => 'Username or Email already exists.'
    ]);
    exit();
  }

  $sql = "INSERT INTO users (
            lakan_firstname,
            lakan_middlename,
            lakan_lastname,
            lakan_username,
            lakan_email,
            lakan_password,
            lakan_pass_confirm
          ) VALUES (
            '$lakan_firstname',
            '$lakan_middlename',
            '$lakan_lastname',
            '$lakan_username',
            '$lakan_email',
            '$hashed_password',
            '$lakan_password'
          )";

  if (mysqli_query($conn, $sql)) {
    echo json_encode([
      'success' => true,
      'message' => 'User added successfully!'
    ]);
    exit();
  }

  echo json_encode([
    'success' => false,
    'message' => 'Error adding user: ' . mysqli_error($conn)
  ]);
  exit();
}
