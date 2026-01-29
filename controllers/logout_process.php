<?php

include '../../connection/connections.php';
session_start();

// Check if the user is an admin
if (isset($_SESSION['emp_id'])) {
	$_SESSION = array();
	session_destroy();
	header("Location: /lakan/index.php");
	exit();
}

?>
