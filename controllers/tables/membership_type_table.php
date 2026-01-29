<?php

// Define table and primary key
$table = 'membership_type';
$primaryKey = 'membership_type_id';
// Define columns for DataTables
$columns = array(
  array(
    'db' => 'membership_type_id',
    'dt' => 0,
    'field' => 'membership_type_id',
    'formatter' => function ($lab1, $row) {
      return $row['membership_type_id'];
    }
  ),
  array(
    'db' => 'membership_type_name',
    'dt' => 1,
    'field' => 'membership_type_name',
    'formatter' => function ($lab2, $row) {
      return $row['membership_type_name'];
    }
  ),

  array(
    'db' => 'membershiptype_price',
    'dt' => 2,
    'field' => 'membershiptype_price',
    'formatter' => function ($value, $row) {
      return '₱ ' . number_format((float)$value, 2);
    }
  ),


  array(
    'db' => 'membershiptype_description',
    'dt' => 3,
    'field' => 'membershiptype_description',
    'formatter' => function ($lab3, $row) {
      return $row['membershiptype_description'];
    }
  ),


  array(
    'db' => 'membership_type_id',
    'dt' => 4,
    'field' => 'membership_type_id',
    'formatter' => function ($lab6, $row) {
      return '
                <div class="dropdown">
                    <button class="btn btn-info" type="button" id="dropdownMenuButton' . $row['membership_type_id'] . '" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &#x22EE;
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row['membership_type_id'] . '">
                        <a class="dropdown-item fetchDataMembershipType" href="#">Configure</a>
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
$where = "membership_type_id";

// Fetch and encode data
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $where));
