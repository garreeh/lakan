<?php
session_start();
include './../connections/connections.php';

if (!isset($_POST['username_or_email'], $_POST['emp_password'])) {
	echo json_encode([
		'success' => false,
		'message' => 'Missing credentials.'
	]);
	exit();
}

$usernameOrEmail = $conn->real_escape_string($_POST['username_or_email']);
$emp_password    = $conn->real_escape_string($_POST['emp_password']);

// Query to Check
$query = "SELECT * FROM users WHERE emp_username = '$usernameOrEmail' OR emp_email = '$usernameOrEmail'";

$result = mysqli_query($conn, $query);

if (!$result) {
	echo json_encode([
		'success' => false,
		'message' => 'Database error: ' . mysqli_error($conn)
	]);
	exit();
}

// Check if username or email exists
if (mysqli_num_rows($result) === 0) {
	echo json_encode([
		'success' => false,
		'message' => 'That username or email doesn’t seem to be registered.'
	]);

	exit();
}

// Finding Matching Password when have same username
$authenticatedUser = null;

while ($row = mysqli_fetch_assoc($result)) {
	if (password_verify($emp_password, $row['emp_password'])) {
		$authenticatedUser = $row;
		break;
	}
}

// Password Wrong
if (!$authenticatedUser) {
	echo json_encode([
		'success' => false,
		'message' => 'The password you entered is incorrect. Please try again.'
	]);
	exit();
}

// Login Success Sessions Save
if ($authenticatedUser['is_password_reset'] == 1) {
	$_SESSION['emp_id'] = $authenticatedUser['emp_id'];
	$_SESSION['emp_email'] = $authenticatedUser['emp_email'];
	$_SESSION['emp_username'] = $authenticatedUser['emp_username'];
	$_SESSION['emp_firstname'] = $authenticatedUser['emp_firstname'];
	$_SESSION['emp_middlename'] = $authenticatedUser['emp_middlename'];
	$_SESSION['emp_lastname'] = $authenticatedUser['emp_lastname'];
	$_SESSION['user_type_id'] = $authenticatedUser['user_type_id'];
	$_SESSION['employment_status'] = $authenticatedUser['employment_status'];
	$_SESSION['is_password_reset'] = $authenticatedUser['is_password_reset'];
}

echo json_encode([
	'success' => true,
	'emp_id'  => $authenticatedUser['emp_id'],
	'is_password_reset' => $authenticatedUser['is_password_reset']
]);
exit();
