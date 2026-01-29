<?php
include './../connections/connections.php';

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

header('Content-Type: application/json');

if (isset($_POST['edit_employee'])) {

  $emp_id = $conn->real_escape_string($_POST['emp_id']);
  $employee_number = $conn->real_escape_string($_POST['employee_number']);
  $emp_email = $conn->real_escape_string($_POST['emp_email']);
  $birth_date = $conn->real_escape_string($_POST['birth_date']);
  $emp_firstname = $conn->real_escape_string($_POST['emp_firstname']);
  $emp_middlename = $conn->real_escape_string($_POST['emp_middlename']);
  $emp_lastname = $conn->real_escape_string($_POST['emp_lastname']);
  $age = $conn->real_escape_string($_POST['age']);
  $religion = $conn->real_escape_string($_POST['religion']);
  $blood_type = $conn->real_escape_string($_POST['blood_type']);
  $suffix = $conn->real_escape_string($_POST['suffix']);
  $civil_status = $conn->real_escape_string($_POST['civil_status']);
  $gender = $conn->real_escape_string($_POST['gender']);
  $position_id = $conn->real_escape_string($_POST['position_id']);
  $region = $conn->real_escape_string($_POST['region']);
  $province = $conn->real_escape_string($_POST['province']);
  $city = $conn->real_escape_string($_POST['city']);
  $barangay = $conn->real_escape_string($_POST['barangay']);
  $zipcode = $conn->real_escape_string($_POST['zipcode']);
  $no_street = $conn->real_escape_string($_POST['no_street']);

  $mobile_number = $conn->real_escape_string($_POST['mobile_number']);
  $tel_number = $conn->real_escape_string($_POST['tel_number']);
  $emergency_contact_no = $conn->real_escape_string($_POST['emergency_contact_no']);
  $emergency_contact_person = $conn->real_escape_string($_POST['emergency_contact_person']);



  $checkNumber = mysqli_query($conn, "SELECT emp_id FROM users WHERE employee_number = '$employee_number' AND emp_id != '$emp_id'");
  if (mysqli_num_rows($checkNumber) > 0) {
    echo json_encode(['success' => false, 'message' => 'Employee Number already exists.']);
    exit();
  }

  $fullNameCheck = mysqli_query($conn, "SELECT emp_id FROM users WHERE emp_firstname = '$emp_firstname' AND emp_lastname = '$emp_lastname' AND emp_id != '$emp_id'");
  if (mysqli_num_rows($fullNameCheck) > 0) {
    echo json_encode(['success' => false, 'message' => 'An employee with the same first and last name already exists.']);
    exit();
  }

  $oldResult = mysqli_query($conn, "SELECT profile_pic FROM users WHERE emp_id = '$emp_id'");
  $oldData = mysqli_fetch_assoc($oldResult);
  $profilePath = $oldData['profile_pic']; // keep old by default

  if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileType = mime_content_type($_FILES['profile_pic']['tmp_name']);

    if (!in_array($fileType, $allowedTypes)) {
      echo json_encode(['success' => false, 'message' => 'Invalid image type. JPG, PNG, GIF only.']);
      exit();
    }

    if ($_FILES['profile_pic']['size'] > 20 * 1024 * 1024) {
      echo json_encode(['success' => false, 'message' => 'Image must be below 20MB.']);
      exit();
    }

    $uploadDir = './../uploads/profile_picture/';
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $extension = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
    $newFileName = 'emp_' . $emp_id . '_' . time() . '.' . $extension;
    $uploadPath = $uploadDir . $newFileName;

    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadPath)) {

      // delete old image if exists
      if (!empty($profilePath) && file_exists($profilePath)) {
        unlink($profilePath);
      }

      $profilePath = $uploadPath;
    }
  }

  $profilePathEscaped = $profilePath ? "'" . $conn->real_escape_string($profilePath) . "'" : "NULL";

  $sql = "UPDATE users SET
      employee_number = '$employee_number',
      emp_email = '$emp_email',
      birth_date = '$birth_date',
      emp_firstname = '$emp_firstname',
      emp_middlename = '$emp_middlename',
      emp_lastname = '$emp_lastname',
      age = '$age',
      religion = '$religion',
      blood_type = '$blood_type',
      suffix = '$suffix',
      civil_status = '$civil_status',
      gender = '$gender',
      position_id = '$position_id',
      region = '$region',
      province = '$province',
      city = '$city',
      barangay = '$barangay',
      zipcode = '$zipcode',
      no_street = '$no_street',

      mobile_number = '$mobile_number',
      tel_number = '$tel_number',
      emergency_contact_no = '$emergency_contact_no',
      emergency_contact_person = '$emergency_contact_person',
      profile_pic = $profilePathEscaped
    WHERE emp_id = '$emp_id'";

  if (mysqli_query($conn, $sql)) {

    $result = mysqli_query($conn, "
      SELECT users.*, position.position_name 
      FROM users 
      LEFT JOIN position ON position.position_id = users.position_id 
      WHERE emp_id = '$emp_id'
    ");

    $employee = mysqli_fetch_assoc($result);

    echo json_encode([
      'success' => true,
      'message' => 'Employee record updated successfully.',
      'employee' => $employee
    ]);
    exit();
  } else {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
    exit();
  }
} else {
  echo json_encode(['success' => false, 'message' => 'No employee data submitted.']);
  exit();
}
