<?php
include './../connections/connections.php';

if (isset($_POST['add_employee'])) {

  // Retrieve and sanitize POST data
  $employee_number = isset($_POST['employee_number']) ? $conn->real_escape_string(trim($_POST['employee_number'])) : '';
  $department_id = isset($_POST['department_id']) ? $conn->real_escape_string(trim($_POST['department_id'])) : '';
  $emp_firstname = isset($_POST['emp_firstname']) ? $conn->real_escape_string(trim($_POST['emp_firstname'])) : '';
  $emp_middlename = isset($_POST['emp_middlename']) ? $conn->real_escape_string(trim($_POST['emp_middlename'])) : '';
  $emp_lastname = isset($_POST['emp_lastname']) ? $conn->real_escape_string(trim($_POST['emp_lastname'])) : '';
  $date_hired = isset($_POST['date_hired']) ? $conn->real_escape_string($_POST['date_hired']) : '';
  $birth_date = isset($_POST['birth_date']) ? $conn->real_escape_string($_POST['birth_date']) : '';

  $default_password = 'p@ssw0rd';
  $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);

  // Check if required fields are empty
  if (empty($employee_number) || empty($emp_firstname) || empty($emp_lastname) || empty($date_hired) || empty($department_id)) {
    echo json_encode([
      'success' => false,
      'message' => 'Please fill in all required fields: Employee Number, First Name, Last Name, Date Hired, and Department.'
    ]);
    exit();
  }

  // CHECK FOR DUPLICATE EMPLOYEE NUMBER
  $number_check_sql = "SELECT * FROM users WHERE employee_number = '$employee_number'";
  $number_check_result = mysqli_query($conn, $number_check_sql);
  if ($number_check_result && mysqli_num_rows($number_check_result) > 0) {
    echo json_encode([
      'success' => false,
      'message' => "The employee number $employee_number is already in use. Please choose a different number."
    ]);
    exit();
  }

  $name_check_sql = "
        SELECT * FROM users 
        WHERE emp_firstname = '$emp_firstname' 
          AND emp_lastname = '$emp_lastname'
    ";
  $name_check_result = mysqli_query($conn, $name_check_sql);

  if ($name_check_result && mysqli_num_rows($name_check_result) > 0) {
    echo json_encode([
      'success' => false,
      'message' => "An employee with the name $emp_firstname $emp_lastname already exists in the system."
    ]);
    exit();
  }

  // INSERT EMPLOYEE
  $insert_sql = "
        INSERT INTO users (employee_number, department_id, emp_firstname, emp_middlename, emp_lastname, date_hired, birth_date, emp_password)
        VALUES ('$employee_number', '$department_id', '$emp_firstname', '$emp_middlename', '$emp_lastname', '$date_hired', '$birth_date', '$hashed_password')
    ";

  if (mysqli_query($conn, $insert_sql)) {
    echo json_encode([
      'success' => true,
      'message' => "Employee $emp_firstname $emp_lastname has been successfully added to the system."
    ]);
  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Failed to add the employee. Please try again later.'
    ]);
  }

  exit();
}
