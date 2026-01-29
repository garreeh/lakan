<?php
session_start();
include './../connections/connections.php';

if (!isset($_POST['username_or_email'], $_POST['lakan_password'])) {
	echo json_encode([
		'success' => false,
		'message' => 'Missing credentials.'
	]);
	exit();
}

$usernameOrEmail = $conn->real_escape_string($_POST['username_or_email']);
$lakan_password = $conn->real_escape_string($_POST['lakan_password']);

// Query to check user by username or email
$query = "SELECT * FROM users WHERE lakan_username = '$usernameOrEmail' OR lakan_email = '$usernameOrEmail'";
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

// Verify password
$authenticatedUser = null;
while ($row = mysqli_fetch_assoc($result)) {
	if (password_verify($lakan_password, $row['lakan_password'])) {
		$authenticatedUser = $row;
		break;
	}
}

// Password incorrect
if (!$authenticatedUser) {
	echo json_encode([
		'success' => false,
		'message' => 'The password you entered is incorrect. Please try again.'
	]);
	exit();
}

// Login Success — Save sessions
$_SESSION['lakan_user_id'] = $authenticatedUser['lakan_user_id'];
$_SESSION['lakan_username'] = $authenticatedUser['lakan_username'];
$_SESSION['lakan_firstname'] = $authenticatedUser['lakan_firstname'];
$_SESSION['lakan_middlename'] = $authenticatedUser['lakan_middlename'];
$_SESSION['lakan_lastname'] = $authenticatedUser['lakan_lastname'];
$_SESSION['user_type_id'] = $authenticatedUser['user_type_id'];

// Return success response
echo json_encode([
	'success' => true,
	'lakan_user_id' => $authenticatedUser['lakan_user_id']
]);
exit();
