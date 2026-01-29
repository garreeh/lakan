<?php

// Set timezone to Manila
date_default_timezone_set('Asia/Manila');

// Define table and primary key
$table = 'users';
$primaryKey = 'lakan_user_id';

// Define columns for DataTables
$columns = array(
  array(
    'db' => 'lakan_user_id',
    'dt' => 0,
    'field' => 'lakan_user_id',
    'formatter' => function ($lab1, $row) {
      return $row['lakan_user_id'];
    }
  ),

  array(
    'db' => 'lakan_firstname',
    'dt' => 1,
    'field' => 'lakan_firstname',
    'formatter' => function ($lab2, $row) {
      return $row['lakan_firstname'];
    }
  ),

  array(
    'db' => 'lakan_lastname',
    'dt' => 2,
    'field' => 'lakan_lastname',
    'formatter' => function ($lab3, $row) {
      return $row['lakan_lastname'];
    }
  ),

  array(
    'db' => 'lakan_username',
    'dt' => 3,
    'field' => 'lakan_username',
    'formatter' => function ($lab3, $row) {
      return $row['lakan_username'];
    }
  ),

  array(
    'db' => 'lakan_email',
    'dt' => 4,
    'field' => 'lakan_email',
    'formatter' => function ($lab3, $row) {
      return $row['lakan_email'];
    }
  ),


  array(
    'db' => 'lakan_user_id',
    'dt' => 5,
    'field' => 'lakan_user_id',
    'formatter' => function ($lab6, $row) {
      return '
                <div class="dropdown">
                    <button class="btn btn-info" type="button" id="dropdownMenuButton' . $row['lakan_user_id'] . '" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['lakan_user_id'] . '">
                        <a class="dropdown-item fetchDataUsers" href="#">Configure</a>
                    </div>
                </div>';
    }
  ),
);

// Database connection details
include './../../connections/ssp_connection.php';

// Include the SSP class
require('./../../assets/datatables/ssp.class_with_where.php');

// Filter only userss where today is between start and end date (Manila timezone)
$today = date('Y-m-d');
$where = "lakan_user_id";

// Fetch and encode data
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
