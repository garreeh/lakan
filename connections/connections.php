<?php

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "lakan";

// $servername = "localhost";
// $username   = "PendragonHrUsr";
// $password   = "TallDust82";
// $dbname     = "pendragonhr";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
  // echo "SUCCESS";
}
