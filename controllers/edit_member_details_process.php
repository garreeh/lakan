<?php
include './../connections/connections.php';

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

header('Content-Type: application/json');

if (isset($_POST['edit_member_details'])) {

  $customer_id = $conn->real_escape_string($_POST['customer_id']);
  $last_name = $conn->real_escape_string($_POST['last_name']);
  $middle_name = $conn->real_escape_string($_POST['middle_name']);
  $first_name = $conn->real_escape_string($_POST['first_name']);
  $birth_date = $conn->real_escape_string($_POST['birth_date']);
  $age = $conn->real_escape_string($_POST['age']);
  $gender = $conn->real_escape_string($_POST['gender']);
  $contact_no = $conn->real_escape_string($_POST['contact_no']);
  $emergency_contact_name = $conn->real_escape_string($_POST['emergency_contact_name']);
  $emergency_contact_no = $conn->real_escape_string($_POST['emergency_contact_no']);
  $email = $conn->real_escape_string($_POST['email']);

  $fullNameCheck = mysqli_query($conn, "SELECT * FROM customer WHERE last_name = '$last_name' AND first_name = '$first_name' AND customer_id != '$customer_id'");
  if (mysqli_num_rows($fullNameCheck) > 0) {
    echo json_encode(['success' => false, 'message' => 'An member with the same first and last name already exists.']);
    exit();
  }

  $oldResult = mysqli_query($conn, "SELECT profile_pic FROM customer WHERE customer_id = '$customer_id'");
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
    $newFileName = 'emp_' . $customer_id . '_' . time() . '.' . $extension;
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

  $sql = "UPDATE customer SET
      last_name = '$last_name',
      middle_name = '$middle_name',
      first_name = '$first_name',
      birth_date = '$birth_date',
      age = '$age',
      gender = '$gender',
      contact_no = '$contact_no',
      emergency_contact_name = '$emergency_contact_name',
      emergency_contact_no = '$emergency_contact_no',
      email = '$email',
      profile_pic = $profilePathEscaped
    WHERE customer_id = '$customer_id'";

  if (mysqli_query($conn, $sql)) {

    $result = mysqli_query($conn, "
      SELECT * 
      FROM customer 
      LEFT JOIN membership_type ON membership_type.membership_type_id = customer.membership_type_id 
      WHERE customer_id = '$customer_id'
    ");

    $member = mysqli_fetch_assoc($result);

    echo json_encode([
      'success' => true,
      'message' => 'Member record updated successfully.',
      'members_data' => $member
    ]);
    exit();
  } else {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
    exit();
  }
} else {
  echo json_encode(['success' => false, 'message' => 'No Member data submitted.']);
  exit();
}
