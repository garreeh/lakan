<?php

// Define table and primary key
$table = 'department';
$primaryKey = 'department_id';
// Define columns for DataTables
$columns = array(
  array(
    'db' => 'department_id',
    'dt' => 0,
    'field' => 'department_id',
    'formatter' => function ($lab1, $row) {
      return $row['department_id'];
    }
  ),
  array(
    'db' => 'department_name',
    'dt' => 1,
    'field' => 'department_name',
    'formatter' => function ($lab2, $row) {
      return $row['department_name'];
    }
  ),
  array(
    'db' => 'department_description',
    'dt' => 2,
    'field' => 'department_description',
    'formatter' => function ($lab3, $row) {
      return $row['department_description'];
    }
  ),

  array(
    'db' => 'created_at',
    'dt' => 3,
    'field' => 'created_at',
    'formatter' => function ($lab5, $row) {
      // Format date to 'Y-m-d' (e.g., 2024-09-03)
      return date('Y-m-d', strtotime($row['created_at']));
    }
  ),

  array(
    'db' => 'updated_at',
    'dt' => 4,
    'field' => 'updated_at',
    'formatter' => function ($lab5, $row) {
      // Format date to 'Y-m-d' (e.g., 2024-09-03)
      return date('Y-m-d', strtotime($row['updated_at']));
    }
  ),

  array(
    'db' => 'department_id',
    'dt' => 5,
    'field' => 'department_id',
    'formatter' => function ($lab6, $row) {
      return '
                <div class="dropdown">
                    <button class="btn btn-info" type="button" id="dropdownMenuButton' . $row['department_id'] . '" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['department_id'] . '">
                        <a class="dropdown-item fetchDataDepartment" href="#">Configure</a>
                    </div>
                </div>';
    }
  ),

);

// Database connection details
include './../../connections/ssp_connection.php';

// Include the SSP class
require('./../../assets/datatables/ssp.class_with_where.php');

// Define where clause if needed
$where = "department_id";

// Fetch and encode data
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
