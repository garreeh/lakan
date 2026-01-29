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

  // Check if required fields are empty
  if (empty($first_name) || empty($last_name) || empty($membership_type_id)) {
    echo json_encode([
      'success' => false,
      'message' => 'Please fill in all required fields:, First Name, Last Name, and Membership Type.'
    ]);
    exit();
  }

  $name_check_sql = "
        SELECT * FROM customer 
        WHERE first_name = '$first_name' 
          AND last_name = '$last_name'
    ";
  $name_check_result = mysqli_query($conn, $name_check_sql);

  if ($name_check_result && mysqli_num_rows($name_check_result) > 0) {
    echo json_encode([
      'success' => false,
      'message' => "An member with the name $first_name $last_name already exists in the system."
    ]);
    exit();
  }

  // INSERT EMPLOYEE
  $insert_sql = "INSERT INTO customer (
                  first_name, 
                  middle_name, 
                  last_name, 
                  birth_date, 
                  age, 
                  start_date_membership, 
                  end_date_membership, 
                  gender, 
                  membership_type_id)
        VALUES ('$first_name', 
                '$middle_name', 
                '$last_name', 
                '$birth_date', 
                '$age', 
                '$start_date_membership', 
                '$end_date_membership', 
                '$gender',
                '$membership_type_id')
    ";

  if (mysqli_query($conn, $insert_sql)) {
    echo json_encode([
      'success' => true,
      'message' => "Member $first_name $last_name has been successfully added to the system."
    ]);
  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Failed to add the employee. Please try again later.'
    ]);
  }

  exit();
}
