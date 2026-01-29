<?php

include '../../connection/connections.php';
session_start();

// Check if the user is an admin
if (isset($_SESSION['lakan_user_id'])) {
	$_SESSION = array();
	session_destroy();
	header("Location: /lakan/index.php");
	exit();
}
